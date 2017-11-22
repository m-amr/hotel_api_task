<?php

namespace AppBundle\Form;

use AppBundle\Model\HotelQueryOptions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class HotelQueryOptionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            TextType::class,
            array(
                'constraints' => array(
                    new Type('string')
                )
            )
        );

        $builder->add(
            'city',
            TextType::class,
            array(
                'constraints' => array(new Type('string'))
            )
        );

        $builder->add(
            'price_from',
            TextType::class,
            array(
                'constraints' => array(
                    new Type('numeric'),
                    new GreaterThanOrEqual(0),
                    new Callback(array($this, 'validatePriceRange'))
                )
            )
        );

        $builder->add(
            'price_to',
            TextType::class,
            array(
                'constraints' => array(
                    new Type('numeric'),
                    new GreaterThanOrEqual(0),
                )
            )
        );

        $builder->add(
            'available_from',
            TextType::class,
            array(
                'constraints' => array(
                    new DateTime(
                        array(
                            'format' => HotelQueryOptions::DATE_TIME_FORMAT,
                            'message' => 'This value is not a valid datetime only d-m-Y is valid format for example 12-1-2014.'
                        )
                    ),
                    new Callback(array($this, 'validateAvailableRange'))
                )
            )
        );

        $builder->add(
            'available_to',
            TextType::class,
            array(
                'constraints' => array(
                    new DateTime(
                        array(
                            'format' => HotelQueryOptions::DATE_TIME_FORMAT,
                            'message' => 'This value is not a valid datetime only d-m-Y is valid format for example 12-1-2014.'
                        )
                    )
                )
            )
        );

        $builder->add(
            'sort_by',
            TextType::class,
            array(
                'constraints' => array(
                   new Callback(array($this, 'validateSortByOption'))
                )
            )
        );
    }

    public function validatePriceRange($object, ExecutionContextInterface $context, $payload)
    {
        $form = $context->getRoot();
        /** @var HotelQueryOptions $data */
        $data = $form->getData();

        switch (true) {
            case ($data->getPriceFrom() !== null && $data->getPriceTo() !== null):
                if ($data->getPriceFrom() >= $data->getPriceTo()) {
                    $context
                        ->buildViolation('price_from must be less than price_to')
                        ->addViolation();
                }
                break;

            case ($data->getPriceFrom() !== null && $data->getPriceTo() === null):
                $context
                    ->buildViolation('price_to is missing.')
                    ->addViolation();
                break;

            case ($data->getPriceFrom() === null && $data->getPriceTo() !== null):
                $context
                    ->buildViolation('price_from is missing.')
                    ->addViolation();
                break;
        }
    }


    public function validateAvailableRange($object, ExecutionContextInterface $context, $payload)
    {
        $form = $context->getRoot();
        /** @var HotelQueryOptions $data */
        $data = $form->getData();

        switch (true) {
            case ($data->getAvailableFrom() !== null && $data->getAvailableTo() !== null):
                $dateFrom = \DateTime::createFromFormat(HotelQueryOptions::DATE_TIME_FORMAT, $data->getAvailableFrom());
                $dateTo = \ DateTime::createFromFormat(HotelQueryOptions::DATE_TIME_FORMAT, $data->getAvailableTo());

                if ($dateFrom >= $dateTo) {
                    $context
                        ->buildViolation('available_from must be less than available_to')
                        ->addViolation();
                }
                break;

            case ($data->getAvailableFrom() !== null && $data->getAvailableTo() === null):
                $context
                    ->buildViolation('available_to is missing.')
                    ->addViolation();
                break;

            case ($data->getAvailableFrom() === null && $data->getAvailableTo() !== null):
                $context
                    ->buildViolation('available_from is missing.')
                    ->addViolation();
                break;
        }
    }

    public function validateSortByOption($object, ExecutionContextInterface $context, $payload)
    {
        $form = $context->getRoot();
        /** @var HotelQueryOptions $data */
        $data = $form->getData();

        if($data->getSortBy() !== null && !in_array($data->getSortBy(), HotelQueryOptions::$SORT_OPTIONS)){
            $context
                ->buildViolation('Only name and price are valid for sort_by')
                ->addViolation();
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'csrf_protection' => false,
                'method' => 'GET',
                'data_class' => 'AppBundle\Model\HotelQueryOptions',
            )
        );
    }

    public function getName()
    {
        return 'options';
    }
}
