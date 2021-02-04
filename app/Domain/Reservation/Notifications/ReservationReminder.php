<?php

namespace App\Domain\Reservation\Notifications;

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

class ReservationReminder extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var mixed
     */
    private $reservation;

    /**
     * @param $reservationId
     */
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    public function toDatabase()
    {
        return [
            'reservation' => $this->reservation,
        ];
    }

    /**
     * @param $notifiable
     */
    public function toFcm($notifiable)
    {

        return FcmMessage::create()
            ->setData(['payload' => [
                'id' => (string) $this->reservation->id,
                'data' => $this->reservation,
                'image' => $this->reservation->user->getFirstMediaUrl('image'),
            ]])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                    ->setTitle('Reservation Reminder')
                    ->setBody('Reminder: Your Reservation is Today')
            )
            ->setTopic('reservation')
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
