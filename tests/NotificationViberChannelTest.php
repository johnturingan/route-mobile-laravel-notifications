<?php
namespace Snp\Tests\Notifications\Rml;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Notifications\Notification;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Snp\Notifications\Rml\Channels\RmlViberChannel;
use Snp\Notifications\Rml\Constants\MessagingMethod;
use Snp\Notifications\Rml\Constants\MessagingType;
use Snp\Notifications\Rml\Messages\ViberMessage;
use Snp\Notifications\Rml\Services\RouteMobileGateway;

class NotificationViberChannelTest extends TestCase
{

    /**
     * @var RmlViberChannel
     */
    private $viberChannel;

    /**
     * @var \Mockery\MockInterface|\GuzzleHttp\Client
     */
    private $guzzleHttp;

    protected function setUp(): void
    {
        parent::setUp();

        $this->guzzleHttp = m::mock(Client::class);
        $this->viberChannel = new RmlViberChannel(new RouteMobileGateway($this->guzzleHttp));
    }

    public function testCorrectPayloadIsSentToViber ()
    {
        $this->guzzleHttp->shouldReceive('post')->andReturnUsing(function ($argUrl, $argPayload)  {
            $this->assertTrue(true);
            return new Response();
        });

        $this->viberChannel->send('6138900629', new LeadAddedNotification());
    }
}

class LeadAddedNotification extends Notification
{

    public function via()
    {
        return ["rmlViber"];
    }


    public function toRMLViber($recipient)
    {
        return (new ViberMessage('This is a viber message from Laravel'))
            ->setRecipient($recipient)
            ->setType(MessagingType::SINGLE_TEXT)
            ->setMethod(MessagingMethod::ONE_WAY)
            ;
    }
}