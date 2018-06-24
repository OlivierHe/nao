<?php

namespace AppBundle\Services;


use AppBundle\Entity\Photo;

class PhotoManager
{

    private $photoDirectory;

    public function __construct($photoDirectoy)
    {
        $this->photoDirectory = $photoDirectoy;
    }

    public function getUploadDir()
    {
        // On retourne le chemin relatif vers l'image pour un navigateur
        return 'web/photos';
    }

    public function getUploadRootDir()
    {
        // On retourne le chemin relatif vers l'image pour notre code PHP
        return $this->photoDirectory;
    }

    public function getWebPath(Photo $photo)
    {
        return $this->getUploadRootDir().'/'.$photo->getId().'.'.$photo->getExtension();
    }
}
