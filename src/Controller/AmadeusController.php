<?php

namespace App\Controller;

use Amadeus\Amadeus;
use App\Service\AmadeusService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AmadeusController extends AbstractController
{
    protected Amadeus $amadeus;

    /**
     * @param AmadeusService $amadeusService
     */
    public function __construct(AmadeusService $amadeusService)
    {
        $this->amadeus = $amadeusService->getAmadeus();
    }

}