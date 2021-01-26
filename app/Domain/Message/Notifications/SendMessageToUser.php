<?php

namespace App\Domain\Message\Notifications;

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

class SendMessageToUser extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var mixed
     */
    private $feed;

    /**
     * @param $feedId
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    public function toDatabase()
    {
        return [
            'link' => route('messages.show', $this->message->id),
            'message' => $this->message->body,
            'title' => $this->message->title,
            'id' => $this->message->id,
        ];
    }

    /**
     * @param $notifiable
     */
    public function toFcm($notifiable)
    {

        return FcmMessage::create()
            ->setData(['payload' => [
                'id' => (string) $this->message->id,
                'data' => $this->message,
            ]])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                    ->setTitle($this->message->title)
                    ->setBody($this->message->body)
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
