<?php

namespace App\Domain\Post\Listeners\Http;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Domain\Post\Events\Http\PostCreated;
use App\Domain\User\Repositories\Contracts\UserRepository;
use App\Domain\Post\Notifications\PostCreated as PostNotification;

class BroadcastPostToUsers implements ShouldQueue
{
    use Queueable;

    /**
     * @var mixed
     */
    private $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param PostCreated $event
     */
    public function handle(PostCreated $event)
    {
        $this->userRepository->whereHas('roles', function ($query) {
            $query->whereSlug('user');
        })->get()->each(function ($user) use ($event) {
            $user->notify(new PostNotification($event->post));
        });
    }
}
