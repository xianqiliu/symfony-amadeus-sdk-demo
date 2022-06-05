<?php

namespace App\Controller;

use Amadeus\Exceptions\ResponseException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class LocationsController extends AmadeusController
{

    /**
     * @Route("/locations", name="locations", methods={"GET"})
     * @throws ResponseException
     */
    public function getLocations(Request $request): JsonResponse
    {
        $locations = $this->amadeus->referenceData->locations->get(
            array(
                "subType" => $request->get('subType'),
                "keyword" => $request->get('keyword'),
                "countryCode" => $request->get('countryCode'),
                "page[limit]" => 10,
                "page[offset]" => $request->get('page')['offset']
            )
        );

        $response = (object) [
            'meta' => $locations[0]->getResponse()->getBodyAsJsonObject()->{'meta'},
            'data' => $locations[0]->getResponse()->getBodyAsJsonObject()->{'data'}
        ];

        return $this->json($response);
    }
}