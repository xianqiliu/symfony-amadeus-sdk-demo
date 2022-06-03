<?php

namespace App\Controller;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class AmadeusController extends AbstractController
{

    /**
     * @Route("/direct-destinations", name="direct_destinations", methods={"GET"})
     * @throws ResponseException
     */
    public function getDestinations(Request $request): Response
    {
        $amadeus = Amadeus::builder(
            $this->getParameter('app.amadeus_client_id'),
            $this->getParameter('app.amadeus_client_secret')
        )->build();

//        $flightOffers = $amadeus->shopping->flightOffers->get(
//            array(
//                "originLocationCode" => $request->get('originLocationCode'),
//                "destinationLocationCode" => $request->get('destinationLocationCode'),
//                "departureDate" => $request->get('departureDate'),
//                "returnDate" => $request->get('returnDate'),
//                "adults" => "1"
//            )
//        );

        $destinations = $amadeus->airport->directDestinations->get(
            array(
                "departureAirportCode" => $request->get('departureAirportCode'),
                "max" => $request->get('max')
            )
        );

        $data = [];

        foreach($destinations as $destination)
        {
            $data[] = $destination->toArray();
        }

        return $this->json($data);
    }
}
