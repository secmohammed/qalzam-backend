<?php

namespace App\Domain\User\Http\Controllers;

use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\User\Http\Resources\Notification\NotificationResourceCollection;

class NotificationController extends Controller
{
    use Responder;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'users';

    /**
     * @var NotificationRepository
     */
    protected $notificationRepository;

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'notifications';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'notification';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->setData('data', auth()->user()->notifications);

        $this->setData('meta', [
            'unread_notifications_count' => auth()->user()->unreadNotifications->count(),
        ]
        );
        $this->useCollection(NotificationResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($notification = null)
    {
        if ($notification) {
            $notification->update([
                'read_at' => now(),
            ]);
        } else {
            auth()->user()->unreadNotifications()->update([
                'read_at' => now(),
            ]);
        }
        $this->setData('data', auth()->user()->notifications);

        $this->setData('meta', [
            'unread_notifications_count' => auth()->user()->unreadNotifications->count(),
        ]
        );
        $this->useCollection(NotificationResourceCollection::class, 'data');

        return $this->response();
    }
}
