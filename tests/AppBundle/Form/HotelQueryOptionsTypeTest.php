<?php

namespace Tests\AppBundle\Form;

use AppBundle\Form\HotelQueryOptionsType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\FormFactory;

class  HotelQueryOptionsTypeTest extends KernelTestCase
{
    /**
     * @var FormFactory
     */
    public $formFactory;

    public function setUp()
    {
        static::bootKernel();
        $this->formFactory = static::$kernel->getContainer()->get('form.factory');
    }

    public function testSubmitValidName()
    {
        $formData = array(
            'name' => '',
        );

        $form = $this->formFactory->create(HotelQueryOptionsType::class);
        $form->submit($formData);
        $this->assertTrue($form->isValid());
    }

    public function testSubmitValidCity()
    {
        $formData = array(
            'city' => 'cairo',
        );

        $form = $this->formFactory->create(HotelQueryOptionsType::class);
        $form->submit($formData);
        $this->assertTrue($form->isValid());
    }

    public function testSubmitValidPrice()
    {
        $formData = array(
            'price_from' => 10,
            'price_to' => 20
        );

        $form = $this->formFactory->create(HotelQueryOptionsType::class);
        $form->submit($formData);
        $this->assertTrue($form->isValid());
    }

    public function testSubmitInValidPrice()
    {
        $formData = array(
            'price_from' => 'aa',
            'price_to' => 'aa'
        );

        $form = $this->formFactory->create(HotelQueryOptionsType::class);
        $form->submit($formData);
        $this->assertFalse($form->isValid());
    }

    public function testSubmitInvalidOnlyPriceFrom()
    {
        $formData = array(
            'price_from' => 10,
        );

        $form = $this->formFactory->create(HotelQueryOptionsType::class);
        $form->submit($formData);
        $this->assertFalse($form->isValid());
    }

    public function testSubmitInvalidOnlyPriceTo()
    {
        $formData = array(
            'price_to' => 10,
        );

        $form = $this->formFactory->create(HotelQueryOptionsType::class);
        $form->submit($formData);
        $this->assertFalse($form->isValid());
    }

    public function testSubmitInvalidPriceFromGreaterThanPriceTo()
    {
        $formData = array(
            'price_from' => 50,
            'price_to' => 40
        );

        $form = $this->formFactory->create(HotelQueryOptionsType::class);
        $form->submit($formData);
        $this->assertFalse($form->isValid());
    }

    public function testSubmitValidAvailableDate()
    {
        $formData = array(
            'available_from' => '1-1-2014',
            'available_to' => '4-1-2014'
        );


        $form = $this->formFactory->create(HotelQueryOptionsType::class);
        $form->submit($formData);
        $this->assertTrue($form->isValid());
    }

    public function testSubmitInValidAvailableDate()
    {
        $formData = array(
            'available_from' => '1-20-2014',
            'available_to' => '4-20-2014'
        );

        $form = $this->formFactory->create(HotelQueryOptionsType::class);
        $form->submit($formData);
        $this->assertFalse($form->isValid());
    }

    public function testSubmitInvalidOnlyAvailableDateFrom()
    {
        $formData = array(
            'available_from' => '1-1-2014',
        );

        $form = $this->formFactory->create(HotelQueryOptionsType::class);
        $form->submit($formData);
        $this->assertFalse($form->isValid());
    }

    public function testSubmitInvalidOnlyAvailableDateTo()
    {
        $formData = array(
            'available_to' => '1-1-2014',
        );

        $form = $this->formFactory->create(HotelQueryOptionsType::class);
        $form->submit($formData);
        $this->assertFalse($form->isValid());
    }

    public function testSubmitInvalidAvailableFromGreaterThanAvailabelTo()
    {
        $formData = array(
            'available_from' => '4-1-2014',
            'available_to' => '1-1-2014'
        );

        $form = $this->formFactory->create(HotelQueryOptionsType::class);
        $form->submit($formData);
        $this->assertFalse($form->isValid());
    }

    public function testSubmitValidSortByPrice()
    {
        $formData = array(
            'sort_by' => 'price',
        );

        $form = $this->formFactory->create(HotelQueryOptionsType::class);
        $form->submit($formData);
        $this->assertTrue($form->isValid());
    }

    public function testSubmitValidSortByName()
    {
        $formData = array(
            'sort_by' => 'name',
        );

        $form = $this->formFactory->create(HotelQueryOptionsType::class);
        $form->submit($formData);
        $this->assertTrue($form->isValid());
    }

    public function testSubmitInValidSortByAnyValue()
    {
        $formData = array(
            'sort' => 'any',
        );

        $form = $this->formFactory->create(HotelQueryOptionsType::class);
        $form->submit($formData);
        $this->assertFalse($form->isValid());
    }
}