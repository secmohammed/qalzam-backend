<?php

namespace App\Domain\Message\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Message\Entities\Message;
use App\Domain\Competition\Entities\Competition;
use App\Domain\Message\Jobs\BroadcastMessageToUsers;
use App\Domain\User\Repositories\Contracts\UserRepository;
use App\Domain\Message\Http\Resources\Message\MessageResource;
use App\Domain\Message\Pipelines\ModifyBrodcastingMessageDelay;
use App\Domain\Message\Repositories\Contracts\MessageRepository;
use App\Domain\Message\Http\Requests\Message\MessageStoreFormRequest;
use App\Domain\Message\Http\Requests\Message\MessageUpdateFormRequest;
use App\Domain\Message\Http\Resources\Message\MessageResourceCollection;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class MessageController extends Controller
{
    use Responder;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'messages';

    /**
     * @var MessageRepository
     */
    protected $messageRepository;

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'messages';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'message';

    /**
     * @param MessageRepository $messageRepository
     */
    public function __construct(MessageRepository $messageRepository, UserRepository $userRepository)
    {
        $this->messageRepository = $messageRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.message'), 'web');
        $this->setData('competitions', Competition::all(), 'web');
        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('action', 'create', 'web');
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
        $i = 0;
        foreach ($this->messageRepository->findMany($ids) as $message) {
            if ($message->delay && $message->delay->lt(now())) {
                $this->redirectRoute("{$this->resourceRoute}.index");
                $this->setApiResponse(fn() => response()->json(['deleted' => false], 422));

                return $this->response();
            }
            $message->delete();
            $i++;
        }

        if ($i) {
            $this->redirectRoute("{$this->resourceRoute}.index");
            $this->setApiResponse(fn() => response()->json(['deleted' => true], 200));
        } else {
            $this->redirectBack();
            $this->setApiResponse(fn() => response()->json(['updated' => false], 422));
        }

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.message') . ' : ' . $message->id, 'web');
        $this->setData('competitions', Competition::all(), 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('edit', $message);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(MessageResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->messageRepository->spatie()->all();

        $this->setData('title', __('main.show-all') . ' ' . __('main.message'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(MessageResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.message') . ' : ' . $message->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('show', $message);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(MessageResource::class, 'show');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageStoreFormRequest $request)
    {
        $message = $this->messageRepository->create($request->validated());
        BroadcastMessageToUsers::dispatch($message)
            ->delay(
                optional(
                    $request->delay, fn($delay) => Carbon::parse($delay)
                ) ?? 0
            )->onQueue('messages');

        $this->setData('data', $message);

        $this->redirectRoute("{$this->resourceRoute}.show", [$message->id]);
        $this->useCollection(MessageResource::class, 'data');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MessageUpdateFormRequest $request, Message $message)
    {
        app(Pipeline::class)->send(['message' => $message, 'request' => $request])->through([
            ModifyBrodcastingMessageDelay::class,
        ])->thenReturn();

        $this->redirectRoute("{$this->resourceRoute}.show", [$message->id]);
        $this->setData('data', $message);
        $this->useCollection(MessageResource::class, 'data');

        return $this->response();
    }
}
