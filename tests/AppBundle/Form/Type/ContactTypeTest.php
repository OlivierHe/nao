<?php
namespace Tests\AppBundle\Form\Type;

use AppBundle\Form\Type\ContactType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class ContactTypeTest extends KernelTestCase
{
  
    private $form;
    private $container;

    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
    }

    public function testSubmitValidData()
    {
        // test l'envoie des données vers la form et la récuperation de ceux-ci
        $formData = array(
            'nomcomplet' => 'testozozo',
            'email' => 'test2@free.fr',
            'objet' => 'lobjet est un test unitaire',
            'message' => 'ouiereoiuqreqrooiu reoiuerqoiureqo oiureqoirueqoriu'
        );

        $this->form = $this->container->get('form.factory');
        $form = $this->form->create(ContactType::class, null);

        $object = $formData;

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
