<?php

namespace Tests\AppBundle\Form;

use AppBundle\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhotoEventListenerTest extends KernelTestCase
{
    /**
     * @var \AppBundle\EventListener\PhotoEventListener
     */
    private $photoListener;
    private $tmpDir;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    protected function setUp()
    {

        self::bootKernel();

        $this->photoListener = static::$kernel->getContainer()->get('app.photo_listener');

        $this->tmpDir = sys_get_temp_dir();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

    }

    public function testPrePersist()
    {
        $photo = new Photo();
        $photo->setFile(new UploadedFile( tempnam($this->tmpDir, uniqid()),'just.jpg', "image/jpeg", 123,UPLOAD_ERR_OK));
        $this->photoListener->prePersist($photo);

        $this->assertEquals('just.jpg', $photo->getAlt());
        $this->assertEquals('jpg', $photo->getFile()->getClientOriginalExtension());

    }

    public function testPostPersist()
    {
        $photo = $this->em->getRepository(Photo::class)->find(1);
        $this->photoListener->postPersist($photo);
        $this->assertEquals('jpeg', $photo->getExtension());
        $this->assertEquals('photo 1', $photo->getAlt());

    }

}