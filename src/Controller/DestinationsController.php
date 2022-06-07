<?php

namespace App\Controller;

use Amadeus\Exceptions\ResponseException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class DestinationsController extends AmadeusController
{

    /**
     * @Route("/direct-destinations", name="direct_destinations", methods={"GET"})
     * @throws ResponseException
     */
    public function getDestinations(Request $request): Response
    {
        $destinations = $this->amadeus->getAirport()->getDirectDestinations()->get(
            array(
                "departureAirportCode" => $request->get('departureAirportCode'),
                "max" => $request->get('max')
            )
        );

        // Custom Response
//        $response = (object) [
//            'meta' => $destinations[0]->getResponse()->getBodyAsJsonObject()->{'meta'},
//            'data' => $destinations[0]->getResponse()->getBodyAsJsonObject()->{'data'}
//        ];

        $response = $destinations[0]->getResponse()->getBodyAsJsonObject();

        return $this->json($response);
    }
}
