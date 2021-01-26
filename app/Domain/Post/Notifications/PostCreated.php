<?php

namespace App\Domain\Post\Notifications;

use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;

class PostCreated extends Notification
{
    /**
     * @var mixed
     */
    private $post;

    /**
     * @param $post
     */
    public function __construct($post)
    {
        $this->post = $post;
    }

    public function toDatabase()
    {
        return [
            'message' => sprintf('view our recent topic: %s', $this->post->title),
            'link' => route('posts.show', $this->post->slug),
            'id' => $this->post->slug,
        ];
    }

    /**
     * @param $notifiable
     */
    public function toFcm($notifiable)
    {

        return FcmMessage::create()
            ->setData(['payload' => [
                'id' => (string) $this->post->id,
                'image' => $this->post->getFirstMediaUrl('image'),
            ]])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                    ->setTitle('Post Created')
                    ->setBody('There is a post created')
            )
            ->setTopic('post')
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
