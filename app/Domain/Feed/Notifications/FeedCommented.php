<?php

namespace App\Domain\Feed\Notifications;

use Illuminate\Bus\Queueable;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;

class FeedCommented extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var mixed
     */
    private $feed;

    /**
     * @param $feedId
     */
    public function __construct($feed, $comment)
    {
        $this->feed = $feed;
        $this->comment = $comment;
    }

    public function toDatabase()
    {
        return [
            'link' => route('feeds.show', $this->feed->id),
            'message' => sprintf('%s commented on your feed', $this->comment->user->name),
            'id' => $this->feed->id,
        ];
    }

    /**
     * @param $notifiable
     */
    public function toFcm($notifiable)
    {

        return FcmMessage::create()
            ->setData(['payload' => [
                'id' => (string) $this->feed->id,
                'image' => $this->feed->user->getFirstMediaUrl('avatar'),
            ]])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                    ->setTitle('Feed Was Commented')
                    ->setBody(sprintf('%s commented on  your feed', $this->comment->user->name))
            )
            ->setTopic('feed')
            ->setAndroid(
                AndroidConfig::create()
                    ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
                    ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'))
            )->setApns(
            ApnsConfig::create()
                ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios')));
    }

    /**
     * @param $notifiable
     */
    public function via($notifiable)
    {

        return [FcmChannel::class, 'database'];
    }
}
