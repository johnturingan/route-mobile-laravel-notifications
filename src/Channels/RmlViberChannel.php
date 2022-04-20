<?php
namespace Snp\Notifications\Rml\Channels;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Notifications\Notification;
use Psr\Http\Message\ResponseInterface;
use Snp\Notifications\Rml\Services\Gateway;

class RmlViberChannel
{
    /** @var Gateway */
    private $gateway;

    /**
     * Create a new Slack channel instance.
     *
     * @param Gateway $gateway
     */
    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param Notification $notification
     * @return ResponseInterface|null
     */
    public function send($notifiable, Notification $notification)
    {

        $model = $this->gateway->login();
        $recipients = is_array($notifiable) ? $notifiable : [$notifiable];

        foreach ($recipients as $recipient) {
            $message = $notification->toRMLViber($recipient);
            $this->gateway->sendMessage($model, $message);
        }
    }
}