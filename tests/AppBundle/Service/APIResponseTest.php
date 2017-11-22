<?php

namespace Tests\AppBundle\Service;


use AppBundle\Service\APIResponse;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use \FOS\RestBundle\View\View;


class APIResponseTest extends TestCase
{
    public function testCreateSuccessJSONView()
    {
        $apiResponse = new APIResponse();

        $actual = $apiResponse->createSuccessJSONView(['data' => 'test']);
        $expected = $this->createViewHelper(
            [
                'isSuccess' => true,
                'errorMessage' => '',
                'data' => ['data' => 'test']
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    public function testCreateErrorJSONView()
    {
        $apiResponse = new APIResponse();

        $actual = $apiResponse->createErrorJSONView('error message');
        $expected = $this->createViewHelper(
            [
                'isSuccess' => false,
                'errorMessage' => 'error message',
                'data' => []
            ]
        );

        $this->assertEquals($expected, $actual);
    }

    public function testPrivateCreateJSONViewWithSuccessArgs()
    {
        //Use reflection to test private methods
        $apiResponseObject = new APIResponse();
        $apiResponseClass = new \ReflectionClass(APIResponse::class);

        $method = $apiResponseClass->getMethod('createJSONView');
        $method->setAccessible(true);

        $actual = $method->invokeArgs($apiResponseObject,[true, ['data'=>'test'], '']);
        $expected = $this->createViewHelper(
            [
                'isSuccess' => true,
                'errorMessage' => '',
                'data' => ['data' => 'test']
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    public function testPrivateCreateJSONViewWithErrorArgs()
    {
        //Use reflection to test private methods
        $apiResponseObject = new APIResponse();
        $apiResponseClass = new \ReflectionClass(APIResponse::class);

        $method = $apiResponseClass->getMethod('createJSONView');
        $method->setAccessible(true);

        $actual = $method->invokeArgs($apiResponseObject,[false, [], 'error message']);
        $expected = $this->createViewHelper(
            [
                'isSuccess' => false,
                'errorMessage' => 'error message',
                'data' => []
            ]
        );
        $this->assertEquals($expected, $actual);
    }

    public function createViewHelper(array $response):View
    {
        $view = View::create($response);
        $view->setFormat('json');
        $view->setHeader("Cache-Control",  "no-store, no-cache, must-revalidate, max-age=0");
        $view->setHeader("Pragma", "no-cache");

        return $view;
    }
}