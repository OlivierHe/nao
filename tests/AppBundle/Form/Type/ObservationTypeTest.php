<?php

namespace Tests\AppBundle\Form;

use AppBundle\Form\Type\ObservationType;
use AppBundle\Repository\TaxrefRepository;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

class ObservationTypeTest extends TypeTestCase
{
    private $repository;

    protected function setUp()
    {
        $this->repository = $this->createMock(TaxrefRepository::class);

        parent::setUp();
    }

    protected function getExtensions()
    {
        $type = new ObservationType($this->repository);

        return array(
            new PreloadedExtension(array($type), array()),
        );
    }

    public function testSubmitValidData()
    {
        $formData = array(
        'taxref' => '25',
        'observationDate' => '3 05 2017',
            'latitude' => '1.3555',
            'longitude' => '1.789',
        );


        $form = $this->factory->create(ObservationType::class);


        $form->submit($formData);

        $this->assertTrue($form->isSynchronized()); //Test DataTransformers


        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}