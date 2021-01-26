<?php

namespace App\Domain\Discount\Notifications;

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

class DiscountAttachedToUser extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var mixed
     */
    private $discountId;

    /**
     * @param $discountId
     */
    public function __construct($discountId)
    {
        $this->discountId = $discountId;
    }

    public function toDatabase()
    {
        return [
            'message' => 'There is a discount assigned to you',
            'link' => route('discounts.show', $this->discountId),
            'id' => $this->discountId,
        ];
    }

    /**
     * @param $notifiable
     */
    public function toFcm($notifiable)
    {

        return FcmMessage::create()
            ->setData(['payload' => (string) $this->discountId])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                    ->setTitle('Reservation Created')
                    ->setBody('There is a discount assigned to you')
            )
            ->setTopic('discount')
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
