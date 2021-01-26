<?php

namespace App\Domain\Message\Jobs;

use Sms;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Domain\Message\Entities\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Domain\Message\Notifications\SendMessageToUser;
use App\Domain\User\Repositories\Contracts\UserRepository;

class BroadcastMessageToUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var mixed
     */
    public $message;

    /**
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->message->competition_id) {
            $users = collect();
            $this->message->competition->children->each(function ($child) use (&$users) {
                $users->push($child->user);
            });
            $users = $users->unique('mobile');
        } else {
            $users = app(UserRepository::class)->whereHas('roles', function ($query) {
                $query->where('slug', '!=', 'admin');
            })->get();

        }
        if ($this->message->type === 'push_notification') {
            $users->each(function ($user) {
                $user->notify(new SendMessageToUser($this->message));
            });
        } else {
            Sms::message($this->message->body)->to($users->pluck('mobile')->toArray())->send();
        }
    }
}
