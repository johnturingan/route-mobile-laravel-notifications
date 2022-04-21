<?php
namespace Snp\Notifications\Rml\Services;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Facades\Cache;
use Snp\Notifications\Rml\Constants\Endpoints;
use Snp\Notifications\Rml\Exceptions\GatewayException;
use Snp\Notifications\Rml\Messages\Payloads\Payload;
use Snp\Notifications\Rml\Messages\ViberMessage;
use Snp\Notifications\Rml\Model\Login;
use Throwable;

class RouteMobileGateway implements Gateway
{
    const PAYLOAD_NAMESPACE = 'Snp\Notifications\Rml\Messages\Payloads\\';

    /**
     * The HTTP client instance.
     *
     * @var HttpClient
     */
    protected $http;

    /**
     * @param HttpClient $http
     */
    function __construct (HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * @throws GatewayException
     */
    public function login()
    {
        try {
            $uri = config('services.route-mobile-notifications.host') . Endpoints::LOGIN;

            if ($val = Cache::get($uri) && config('services.route-mobile-notifications.cache')) {
                $response = $val;
            } else {
                $response = $this->http->post($uri, [
                    'json' => [
                        'username' => config('services.route-mobile-notifications.username'),
                        'password' => config('services.route-mobile-notifications.password')
                    ]
                ]);

                $result = json_decode($response->getBody()->getContents(), 1);
                $response = new Login($result);
                Cache::put($uri, $response, $response->getExpiry());
            }

            return $response;

        } catch (Throwable $e) {
            throw new GatewayException($e->getMessage(), 4001);
        }
    }

    /**
     * @param Login $login
     * @param ViberMessage $message
     * @throws GatewayException
     */
    public function sendMessage(Login $login, ViberMessage $message)
    {
        try {

            /** @var Payload $payload */
            $payload = app()->make(self::PAYLOAD_NAMESPACE.$message->type(), ['message' => $message]);
            $uri = config('services.route-mobile-notifications.host') . $payload->endpoint();

            $this->http->post($uri, [
                'json' => $payload->toArray(),
                'headers' => [
                    'Authorization' => $login->token()
                ]
            ]);

            return $payload->toArray();

        } catch (Throwable $e) {
            throw new GatewayException($e->getMessage(), 4003);
        }
    }
}