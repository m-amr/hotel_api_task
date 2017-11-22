<?php

namespace AppBundle\Service;

use \FOS\RestBundle\View\View;

class APIResponse
{
    /**
     * @param $data
     *
     * @return View
     */
    public function createSuccessJSONView(array $data):View
    {
        return $this->createJSONView(true, $data, '');
    }

    /**
     * @param $errorMessage
     *
     * @return View
     */
    public function createErrorJSONView(string $errorMessage):View
    {
        return $this->createJSONView(false, [], $errorMessage);
    }

    /**
     * @param $isSuccess
     * @param $data
     * @param $errorMessage
     *
     * @return View
     */
    private function createJSONView(bool $isSuccess, array $data, string $errorMessage):View
    {
        $response = array(
            'isSuccess' => $isSuccess,
            'errorMessage' => $errorMessage,
            'data' => $data
        );

        /**
         * @var View $view
         */
        $view = View::create($response);
        $view->setFormat('json');
        $view->setHeader("Cache-Control", "no-cache, no-store, must-revalidate, max-age=0");
        $view->setHeader("Pragma", "no-cache");

        return $view;
    }
}