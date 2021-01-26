<?php

namespace App\Domain\Order\Notifications;

use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;

class OrderPlaced extends Notification
{
    /**
     * @var mixed
     */
    private $order;

    /**
     * @param $meetingId
     */
    public function __construct($order)
    {
        $this->order = $order;
        $this->message = 'Order has been created';
    }

    public function toDatabase()
    {
        return [
            'id' => $this->order->id,
            'link' => route('orders.show', $this->order->id),
            'message' => $this->message,
        ];
    }

    /**
     * @param $notifiable
     */
    public function toFcm($notifiable)
    {

        return FcmMessage::create()
            ->setData(['payload' => (string) $this->order->id, 'message' => $this->message])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                    ->setTitle('Order Created')
                    ->setBody($this->message)
            )
            ->setTopic('order')
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
