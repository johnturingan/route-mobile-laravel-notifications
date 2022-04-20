<?php

namespace Snp\Notifications\Rml\Services;

use Snp\Notifications\Rml\Messages\ViberMessage;
use Snp\Notifications\Rml\Model\Login;

interface Gateway
{

    public function login();
    public function sendMessage(Login $login, ViberMessage $message);
}