<?php
namespace Snp\Notifications\Rml\Messages;


use Snp\Notifications\Rml\Constants\MessagingType;

class ViberMessage
{
    protected $content;
    protected $recipient;

    protected $method;
    protected $type;

    public function __construct(string $content = '')
    {
        $this->content = $content;
    }

    /**
     * @return $this
     */
    public function setType ($value)
    {
        $this->type = $value;
        return $this;
    }

    public function type ()
    {
        return $this->type ?? MessagingType::SINGLE_TEXT;
    }

    public function setMethod ($value)
    {
        $this->method = $value;
        return $this;
    }

    public function method ()
    {
        return $this->method;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setRecipient($value)
    {
        $this->recipient = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function recipient()
    {
        return $this->recipient;
    }

    /**
     * @return string
     */
    public function content()
    {
        return $this->content;
    }
}