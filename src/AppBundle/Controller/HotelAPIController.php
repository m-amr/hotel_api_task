<?php

namespace AppBundle\Controller;

use AppBundle\Form\HotelQueryOptionsType;
use AppBundle\Model\HotelQueryOptions;
use AppBundle\Service\AbstractHotelAPI;
use AppBundle\Service\APIResponse;
use AppBundle\Service\HotelService;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;

class HotelAPIController extends FOSRestController
{
    public function getHotelsAction(Request $request)
    {
        /** @var HotelService $hotelAPI */
        $hotelService= $this->get('hotel_service');
        /** @var APIResponse $apiResponse */
        $apiResponse = $this->get('api_response');

        $form = $this->createForm(HotelQueryOptionsType::class);
        $form->submit($request->query->all());
        $view = null;

        if($form->isValid())
        {
            /** @var HotelQueryOptions $queryOption */
            $queryOptions = $form->getData();
            $response = $hotelService->search($queryOptions);
            $view = $apiResponse->createSuccessJSONView(['hotels'=>$response]);

        }
        else{
            $view = $apiResponse->createErrorJSONView((string) $form->getErrors(true, false));
        }

        return $this->handleView($view);
    }
}
