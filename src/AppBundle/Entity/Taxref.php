<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Taxref
 *
 * @ORM\Table(name="taxref")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TaxrefRepository")
 */
class Taxref
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom_ref", type="string", length=150, nullable=false)
     */
    private $nomRef;

    /**
     * @var string
     *
     * @ORM\Column(name="syn_cre", type="string", length=1500, nullable=true)
     */
    private $synCre;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_vern", type="string", length=150, nullable=true)
     */
    private $nomVern;

    /**
     * @var string
     *
     * @ORM\Column(name="ordre", type="string", length=60, nullable=false)
     */
    private $ordre;

    /**
     * @var string
     *
     * @ORM\Column(name="famille", type="string", length=60, nullable=false)
     */
    private $famille;

    /**
     * @var integer
     *
     * @ORM\Column(name="cd_ref", type="integer", nullable=false)
     */
    private $cdRef;

    /**
     * @var integer
     *
     * @ORM\Column(name="cd_nom", type="integer", nullable=false)
     */
    private $cdNom;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Observation", mappedBy="taxref", orphanRemoval=true )
     * @ORM\JoinColumn(nullable=true)
     */
    private $observations;

    /**
     * Set nomRef
     *
     * @param string $nomRef
     *
     * @return Taxref
     */
    public function setNomRef($nomRef)
    {
        $this->nomRef = $nomRef;

        return $this;
    }

    /**
     * Get nomRef
     *
     * @return string
     */
    public function getNomRef()
    {
        return $this->nomRef;
    }

    /**
     * Set synCre
     *
     * @param string $synCre
     *
     * @return Taxref
     */
    public function setSynCre($synCre)
    {
        $this->synCre = $synCre;

        return $this;
    }

    /**
     * Get synCre
     *
     * @return string
     */
    public function getSynCre()
    {
        return $this->synCre;
    }

    /**
     * Set nomVern
     *
     * @param string $nomVern
     *
     * @return Taxref
     */
    public function setNomVern($nomVern)
    {
        $this->nomVern = $nomVern;

        return $this;
    }

    /**
     * Get nomVern
     *
     * @return string
     */
    public function getNomVern()
    {
        return $this->nomVern;
    }

    /**
     * Set ordre
     *
     * @param string $ordre
     *
     * @return Taxref
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return string
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set famille
     *
     * @param string $famille
     *
     * @return Taxref
     */
    public function setFamille($famille)
    {
        $this->famille = $famille;

        return $this;
    }

    /**
     * Get famille
     *
     * @return string
     */
    public function getFamille()
    {
        return $this->famille;
    }

    /**
     * Set cdRef
     *
     * @param integer $cdRef
     *
     * @return Taxref
     */
    public function setCdRef($cdRef)
    {
        $this->cdRef = $cdRef;

        return $this;
    }

    /**
     * Get cdRef
     *
     * @return integer
     */
    public function getCdRef()
    {
        return $this->cdRef;
    }

    /**
     * Set cdNom
     *
     * @param integer $cdNom
     *
     * @return Taxref
     */
    public function setCdNom($cdNom)
    {
        $this->cdNom = $cdNom;

        return $this;
    }

    /**
     * Get cdNom
     *
     * @return integer
     */
    public function getCdNom()
    {
        return $this->cdNom;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * @param mixed $observations
     */
    public function setObservations($observations)
    {
        $this->observations = $observations;
    }
}
