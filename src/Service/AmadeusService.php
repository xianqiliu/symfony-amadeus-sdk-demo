<?php

namespace App\Service;

use Amadeus\Amadeus;

class AmadeusService
{
    private Amadeus $amadeus;

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->amadeus = Amadeus::builder(
            $clientId,
            $clientSecret
        )->build();
    }

    public function getAmadeus(): Amadeus
    {
        return $this->amadeus;
    }
}