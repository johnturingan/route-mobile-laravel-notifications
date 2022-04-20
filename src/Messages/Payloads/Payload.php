<?php

namespace Snp\Notifications\Rml\Messages\Payloads;

interface Payload
{
    public function endpoint ();
    public function toArray();
}