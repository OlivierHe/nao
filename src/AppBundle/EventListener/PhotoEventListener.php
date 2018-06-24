<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Photo;
use AppBundle\Services\PhotoManager;
use Doctrine\ORM\Mapping\PostPersist;
use Doctrine\ORM\Mapping\PostRemove;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreRemove;
use Doctrine\ORM\Mapping\PostUpdate;
use Doctrine\ORM\Mapping\PreUpdate;

class PhotoEventListener
{
    private $photoManager;

    public function __construct(PhotoManager $photoManager)
    {
        $this->photoManager = $photoManager;
    }

    /**
     * @PrePersist
     * @PreUpdate()
     */
    public function prePersist(Photo $photo)
    {
        // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
        if (null === $photo->getFile()) {
            return;
        }

        $photo->setExtension( $photo->getFile()->guessExtension()) ;
        $photo->setAlt($photo->getFile()->getClientOriginalName());
    }


    /**
     * @PostPersist()
     * @PostUpdate()
     */
    public function  postPersist(Photo $photo){
        // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
        if (null === $photo->getFile()) {
            return;
        }
        // Si on avait un ancien fichier, on le supprime
        if (null !== $photo->getTempFilename()) {
            $oldFile = $this->photoManager->getUploadRootDir().'/'.$photo->getId().'.'.$photo->getTempFilename();
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        // On déplace le fichier envoyé dans le répertoire de notre choix
        $photo->getFile()->move(
            $this->photoManager->getUploadRootDir(), // Le répertoire de destination
            $photo->getId().'.'.$photo->getExtension()   // Le nom du fichier à créer, ici « id.extension »
        );
    }


    /** @PreRemove() */
    public function preRemove(Photo $photo){

        // On sauvegarde temporairement le nom du fichier, car il dépend de l'id
        $photo->setTempFilename($this->photoManager->getUploadRootDir().'/'.$photo->getId().'.'.$photo->getExtension());
    }


    /** @PostRemove() */
    public function postRemove(Photo $photo){
        // En PostRemove, on n'a pas accès à l'id, on utilise notre nom sauvegardé
        if (file_exists($photo->getTempFilename())) {
            // On supprime le fichier
            unlink($photo->getTempFilename());
        }
    }
}
