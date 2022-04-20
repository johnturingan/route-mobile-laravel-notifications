<?php
namespace Snp\Notifications\Rml\Messages\Payloads;


use Snp\Notifications\Rml\Constants\Endpoints;
use Snp\Notifications\Rml\Messages\ViberMessage;

class SingleText implements Payload
{
    private ViberMessage $message;

    /**
     * @param ViberMessage $message
     */
    public function __construct(ViberMessage $message)
    {
        $this->message = $message;
    }

    public function endpoint ()
    {
        return Endpoints::VIBER_SINGLE_TEXT;
    }

    public function toArray()
    {
        return [
            "phone" => $this->message->recipient(),
            "text" => $this->message->content(),
            "message_type" => 'text',
            "method" => $this->message->method()
        ];
    }
}