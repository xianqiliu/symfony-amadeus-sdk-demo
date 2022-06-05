<?php

namespace App\Controller;

use Amadeus\Exceptions\ResponseException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class DestinationController extends AmadeusController
{

    /**
     * @Route("/direct-destinations", name="direct_destinations", methods={"GET"})
     * @throws ResponseException
     */
    public function getDestinations(Request $request): Response
    {
        $destinations = $this->amadeus->airport->directDestinations->get(
            array(
                "departureAirportCode" => $request->get('departureAirportCode'),
                "max" => $request->get('max')
            )
        );

//        $data = [];
//        foreach($destinations as $destination)
//        {
//            $data[] = $destination->toArray();
//        }

        $response = (object) [
            'meta' => $destinations[0]->getResponse()->getBodyAsJsonObject()->{'meta'},
            'data' => $destinations[0]->getResponse()->getBodyAsJsonObject()->{'data'}
        ];

        return $this->json($response);
    }
}
