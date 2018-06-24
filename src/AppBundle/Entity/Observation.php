<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Observation
 *
 * @ORM\Table(name="observation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ObservationRepository")
 */
class Observation
{

    const STATE_VALID = "Validé";
    const STATE_WAITING = "En attente";
    const STATE_REFUSED = "Refusé";


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime()
     * @Assert\LessThanOrEqual("today")
     */
    private $date;

    /**
     *
     * @ORM\Column(name="observation_date", type="date")
     * @Assert\Date()
     * @Assert\LessThan("tomorrow")
     * @Assert\NotNull()
     */
    private $observationDate;

    /**
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Taxref", inversedBy="observations",cascade={"persist"})
     * @Assert\NotNull()
     */
    private $taxref;

    /**
     *
     * @ORM\Column(name="longitude", type="float")
     * @Assert\LessThanOrEqual(180)
     * @Assert\GreaterThanOrEqual(-180)
     * @Assert\NotNull()
     */
    private $longitude;

    /**
     * @ORM\Column(name="latitude", type="float")
     * @Assert\LessThanOrEqual(90)
     * @Assert\GreaterThanOrEqual(-90)
     * @Assert\NotNull()
     */
    private $latitude;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="observations",cascade={"persist"})
     */
    private $author;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="validatedByUser",cascade={"persist"})
     */
    private $validatedBy;

    /**
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Photo", cascade={"persist","remove"})
     * @Assert\Valid()
     *
     */
    private $photo;

    /**
     * @ORM\Column(name="state", type="string", length=255)
     * @Assert\Choice(choices = {Observation::STATE_VALID, Observation::STATE_REFUSED,Observation::STATE_WAITING },strict=true)
     */
    private $state; // L'état de l'observation




    public function __construct()
    {


    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Observation
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }



    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }


    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getValidatedBy()
    {
        return $this->validatedBy;
    }

    /**
     * @param mixed $validatedBy
     */
    public function setValidatedBy($validatedBy)
    {
        $this->validatedBy = $validatedBy;
    }


    /**
     * @return \DateTime
     */
    public function getObservationDate()
    {
        return $this->observationDate;
    }

    /**
     * @param \DateTime $observationDate
     */
    public function setObservationDate($observationDate)
    {
        $this->observationDate = $observationDate;
    }

    /**
     * @return mixed
     */
    public function getTaxref()
    {
        return $this->taxref;
    }

    /**
     * @param mixed $taxref
     */
    public function setTaxref($taxref)
    {
        $this->taxref = $taxref;
    }
}


