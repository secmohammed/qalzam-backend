<?php

namespace App\Domain\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Dashboard\Entities\Dashboard;
use App\Domain\Order\Repositories\Contracts\OrderRepository;
use App\Domain\Dashboard\Repositories\Contracts\DashboardRepository;
use App\Domain\Reservation\Repositories\Contracts\ReservationRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class DashboardController extends Controller
{
    use Responder;

    /**
     * @var DashboardRepository
     */

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'dashboards';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'dashboards';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'dashboard';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ReservationRepository $reservationRepository, OrderRepository $orderRepository)
    {
        $pendingOrdersCount = $orderRepository->where('status', 'pending')->count();
        $recentReservations =  $reservationRepository->latest()->limit(5)->get()->load(['branch']);
        $recentOrders = $orderRepository->latest()->limit(5)->where('status', 'pending')->get()->load(['branch', 'products', 'user', 'deliverers']);
        return view("{$this->domainAlias}::{$this->viewPath}.index")->with(compact('recentReservations', 'recentOrders', 'pendingOrdersCount'));
    }
}
