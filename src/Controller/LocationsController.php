<?php

namespace App\Controller;

use Amadeus\Exceptions\ResponseException;
use SplFixedArray;
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
        $baseLink = "/api/locations?subType=CITY&keyword=PAR&page[offset]=";
        $pageLimit = 7;

        $locations = $this->amadeus->getReferenceData()->getLocations()->get(
            array(
                "subType" => $request->get('subType'),
                "keyword" => $request->get('keyword'),
                "countryCode" => $request->get('countryCode'),
                "page[limit]" => $pageLimit,
                "page[offset]" => $request->get('page')['offset']
            )
        );

        $meta = empty($locations) ? null : $locations[0]->getResponse()->getBodyAsJsonObject()->{'meta'};

        $links = $meta->{'links'};
        foreach ($links as $key => $url )
        {
            $url = explode('?', $url);
            $newUrl = "/api/locations?" . $url[ count($url) - 1 ];
            $links->$key = $newUrl;
        }

        $pageCount = ($meta->{'count'} < $pageLimit) ? 1 : ceil($meta->{'count'} / $pageLimit);
        $meta->{'pageCount'} = $pageCount;

        $linksForEachPage = new SplFixedArray($pageCount);
        foreach ($linksForEachPage as $key => $value) {
            $linksForEachPage[$key] = $baseLink.($pageLimit*$key);
        }
        $meta->{'linksForEachPage'} = $linksForEachPage;

        $response = (object) [
            'meta' => $meta,
            'data' => $locations[0]->getResponse()->getBodyAsJsonObject()->{'data'}
        ];

        return $this->json($response);
    }
}