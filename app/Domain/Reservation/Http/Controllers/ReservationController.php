<?php

namespace App\Domain\Reservation\Http\Controllers;

use App\Domain\Accommodation\Repositories\Contracts\AccommodationRepository;
use App\Domain\Branch\Repositories\Contracts\BranchRepository;
use App\Domain\Order\Repositories\Contracts\OrderRepository;
use App\Domain\Reservation\Entities\Reservation;
use App\Domain\Reservation\Http\Requests\Reservation\ReservationStoreFormRequest;
use App\Domain\Reservation\Http\Requests\Reservation\ReservationUpdateFormRequest;
use App\Domain\Reservation\Http\Resources\Reservation\ReservationResource;
use App\Domain\Reservation\Http\Resources\Reservation\ReservationResourceCollection;
use App\Domain\Reservation\Notifications\ReservationCreated;
use App\Domain\Reservation\Notifications\ReservationUpdated;
use App\Domain\Reservation\Pipelines\CalculateReservationPrice;
use App\Domain\Reservation\Pipelines\CreateReservation;
use App\Domain\Reservation\Pipelines\ValidateReservationStartDateAndEndDateIfAvailable;
use App\Domain\Reservation\Pipelines\ValidateReservationStartDateAndEndDateIsWithinBranchAvailability;
use App\Domain\Reservation\Repositories\Contracts\ReservationRepository;
use App\Domain\User\Repositories\Contracts\UserRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Joovlly\DDD\Traits\Responder;

/*
 * When Creating a reservation, it must be during the working hour of the branch,
 * we will validate that through the form request for sake of simplicity.
 * when user is trying to attempt a reservation, we will check if the datetime range of it *
 *  isn't during any other reservation datetime (start_date, end_date)
 * when creating the reservation, we will take the accommodation_id in order to take the
 *  price as well, in order to log the reservation price due to the accommodation price
 * may varies.
 * the reservation must have a price which formulates the total submission of the products of the template which attachedd to the contract (that's only in case of the type of accommodation is room.)
 */
class ReservationController extends Controller
{
    use Responder;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'reservations';

    /**
     * @var ReservationRepository
     */
    protected $reservationRepository;

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'reservations';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'reservation';

    /**
     * @param ReservationRepository $reservationRepository
     */
    public function __construct(ReservationRepository $reservationRepository, AccommodationRepository $accommodationRepository, BranchRepository $branchRepository, OrderRepository $orderRepository, UserRepository $userRepository)
    {
        $this->reservationRepository = $reservationRepository;
        $this->accommodationRepository = $accommodationRepository;
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->branchRepository = $branchRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.reservation'), 'web');
        // $this->setData('accommodations', $this->accommodationRepository->all());
        $this->setData('branches', $this->branchRepository->with("accommodations")->all());
        $this->setData('orders', $this->orderRepository->all());
        $this->setData('users', $this->userRepository->all());
        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('auth_token', auth()->user()->generateAuthToken());

        $this->addView("{$this->domainAlias}::{$this->viewPath}.create");

        $this->setApiResponse(fn() => response()->json(['create_your_own_form' => true]));

        return $this->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ids = request()->get('ids', $id);
        $delete = $this->reservationRepository->destroy($ids)->count();

        if ($delete) {
            $this->redirectRoute("{$this->resourceRoute}.index");
            $this->setApiResponse(fn() => response()->json(['deleted' => true], 200));
        } else {
            $this->redirectBack();
            $this->setApiResponse(fn() => response()->json(['deleted' => false], 404));
        }

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.reservation') . ' : ' . $reservation->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('accommodations', $this->accommodationRepository->all());
        $this->setData('orders', $this->orderRepository->all());
        $this->setData('users', $this->userRepository->all());

        $this->setData('edit', $reservation);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(ReservationResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->reservationRepository->spatie()->paginate(
            $request->per_page ?? config('qalzam.pagination')
        );

        $this->setData('title', __('main.show-all') . ' ' . __('main.reservation'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(ReservationResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.reservation') . ' : ' . $reservation->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        if (!request()->wantsJson()) {
            $reservation->load(['accommodation']);
        }
        $this->setData('reservation', $reservation);
        $this->setData('meta', [
            'total_price' => $reservation->formatted_total_price,
        ]);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(ReservationResource::class, 'reservation');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationStoreFormRequest $request)
    {
        // dd(2);
        $reservation = app(Pipeline::class)->send($request)->through([
            ValidateReservationStartDateAndEndDateIsWithinBranchAvailability::class,
            ValidateReservationStartDateAndEndDateIfAvailable::class,
            CalculateReservationPrice::class,
            CreateReservation::class,
        ])->thenReturn();
        dd(1, $reservation);
        $reservation->user->notify(new ReservationCreated($reservation));

        $this->setData('data', $reservation);

        $this->redirectRoute("{$this->resourceRoute}.show", [$reservation->id]);
        $this->useCollection(ReservationResource::class, 'data');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReservationUpdateFormRequest $request, Reservation $reservation)
    {
        app(Pipeline::class)->send($request)->through([
            ValidateReservationStartDateAndEndDateIsWithinBranchAvailability::class,
            ValidateReservationStartDateAndEndDateIfAvailable::class,
            CalculateReservationPrice::class,

        ])->thenReturn();

        $reservation->update($request->validated() + ['price' => $request->price]);
        $reservation->user->notify(new ReservationUpdated($reservation));

        $this->redirectRoute("{$this->resourceRoute}.show", [$reservation->id]);
        $this->setData('data', $reservation);
        $this->useCollection(ReservationResource::class, 'data');

        return $this->response();
    }

    public function inout()
    {
        return view("{$this->domainAlias}::{$this->viewPath}.inout");
    }
}
