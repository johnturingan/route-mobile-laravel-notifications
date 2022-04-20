<?php
namespace Snp\Notifications\Rml\Model;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Snp\Notifications\Rml\Exceptions\GatewayException;

class Login
{

    protected $username;
    protected $first_name;
    protected $last_name;
    protected $email;
    protected $phone_number;
    protected $password_reset;
    protected $is_active;
    protected $is_staff;
    protected $ip;
    protected $token;
    protected $payload = [];

    /**
     * @param array $data
     * @throws GatewayException
     */
    function __construct ($data = [])
    {

        $this->username = $data['user_data']['username'];
        $this->first_name = $data['user_data']['first_name'];
        $this->last_name = $data['user_data']['last_name'];
        $this->email = $data['user_data']['email'];
        $this->phone_number = $data['user_data']['phone_number'];
        $this->password_reset = $data['user_data']['password_reset'];
        $this->is_active = $data['user_data']['is_active'];
        $this->is_staff = $data['user_data']['is_staff'];
        $this->ip = $data['user_data']['ip'];
        $this->token = $data['JWTAUTH'] ?? '';

        // Let's get the payload segment of the JWT
        $jwt = explode('.', $data['JWTAUTH'] ?? '');

        // We need to make sure that we have 3
        // segments of the JWT, otherwise it's not valid
        if (count($jwt) !== 3) {
            throw new GatewayException ('Invalid Login', 4002);
        }

        $this->payload = json_decode(base64_decode($jwt[1]), 1);
    }

    /**
     * @return mixed|string
     */
    public function token()
    {
        return $this->token;
    }

    /**
     * @return Carbon
     */
    public function getExpiry ()
    {
        return Carbon::createFromTimestampUTC($this->payload['exp']);
    }
}