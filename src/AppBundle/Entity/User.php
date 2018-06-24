<?php

// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 * 
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(
 * fields={"username"},
 * message="Cette adresse email est déjà utilisée.")
 * @UniqueEntity(
 * fields={"pseudo"},
 * message="Ce pseudonyme est déjà utilisé.")
 */
class User implements UserInterface, \Serializable
{
    CONST PARTICULIER = 'ROLE_PARTICULIER';
    CONST NATURALISTE = 'ROLE_NATURALISTE';
    CONST EN_ATTENTE_DE_VALIDATION = 'ROLE_EN_ATTENTE_DE_VALIDATION';


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=255)
     *
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthDate", type="datetime")
     * @Assert\Date(message="Ceci n'est pas une date valide")
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     *
     */
    private $username;


    /**
     * @var
     *
     * @ORM\Column(name="pseudo", type="string", length=255, unique=true)
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;


    /**
     * @ORM\Column(name="roles", type="array")
     */
    private $roles = array();


    /**
     * @var string
     *
     * @ORM\Column(name="account", type="string")
     */
    private $account;


    /**
     * @var boolean
     *
     * @ORM\Column(name="validMail", type="boolean", nullable=true)
     */
    private $validMail;

    /**
     * @var boolean
     *
     * @ORM\Column(name="member", type="boolean", nullable=true)
     */
    private $member;



    /**
     * @var \datetime
     *
     * @ORM\Column(name="dateInscription", type="datetime", nullable=false)
     */
    private $dateRegistration;


    /**
     * @ORM\Column(name="code_validation", type="string")
     */
    private $code_validation;


    /**
     * @var bool
     *
     * @ORM\Column(name="mentionsLegales", type="boolean")
     */
    private $mentionsLegales;


    /**
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Photo", cascade={"persist","remove"})
     * @Assert\Valid()
     */
    private $justificatif;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Observation", mappedBy="author", orphanRemoval=true )
     */
    private $observations;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Observation", mappedBy="validatedBy", orphanRemoval=true )
     */
    private $validatedByUser;


    public function __construct()
    {
        $this->observations = new ArrayCollection();
        $this->validatedByUser = new ArrayCollection();
        $this->code_validation = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz123456789"), 0, rand(20,40));
        $this->dateRegistration = new \DateTime();
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
     * Set gender
     *
     * @param boolean $gender
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return bool
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return User
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }


    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set account
     *
     * @param string $account
     *
     * @return User
     */
    public function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }


    /**
     * Add observation
     *
     * @param \AppBundle\Entity\Observation $observation
     *
     * @return User
     */
    public function addObservation(Observation $observation)
    {
        $this->observations[] = $observation;

        return $this;
    }

    /**
     * Remove observation
     *
     * @param \AppBundle\Entity\Observation $observation
     */
    public function removeObservation(Observation $observation)
    {
        $this->observations->removeElement($observation);
    }

    /**
     * Get observations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * Add validatedByUser
     *
     * @param \AppBundle\Entity\Observation $validatedByUser
     *
     * @return User
     */
    public function addValidatedByUser(Observation $validatedByUser)
    {
        $this->validatedByUser[] = $validatedByUser;

        return $this;
    }

    /**
     * Remove validatedByUser
     *
     * @param \AppBundle\Entity\Observation $validatedByUser
     */
    public function removeValidatedByUser(Observation $validatedByUser)
    {
        $this->validatedByUser->removeElement($validatedByUser);
    }

    /**
     * Get validatedByUser
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getValidatedByUser()
    {
        return $this->validatedByUser;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    public function eraseCredentials()
    {
    }

    /**
     * Set pseudo
     *
     * @param string $pseudo
     *
     * @return User
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set validMail
     *
     * @param boolean $validMail
     *
     * @return User
     */
    public function setValidMail($validMail)
    {
        $this->validMail = $validMail;

        return $this;
    }

    /**
     * Get validMail
     *
     * @return boolean
     */
    public function getValidMail()
    {
        return $this->validMail;
    }

    /**
     * Set mentionsLegales
     *
     * @param boolean $mentionsLegales
     *
     * @return User
     */
    public function setMentionsLegales($mentionsLegales)
    {
        $this->mentionsLegales = $mentionsLegales;

        return $this;
    }

    /**
     * Get mentionsLegales
     *
     * @return boolean
     */
    public function getMentionsLegales()
    {
        return $this->mentionsLegales;
    }


    /**
     * Set codeValidation
     *
     * @param string $codeValidation
     *
     * @return User
     */
    public function setCodeValidation($codeValidation)
    {
        $this->code_validation = $codeValidation;

        return $this;
    }

    /**
     * Get codeValidation
     *
     * @return string
     */
    public function getCodeValidation()
    {
        return $this->code_validation;
    }

    /**
     * Set member
     *
     * @param boolean $member
     *
     * @return User
     */
    public function setMember($member)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * Get member
     *
     * @return boolean
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * Set dateRegistration
     *
     * @param \DateTime $dateRegistration
     *
     * @return User
     */
    public function setDateRegistration($dateRegistration)
    {
        $this->dateRegistration = $dateRegistration;

        return $this;
    }

    /**
     * Get dateRegistration
     *
     * @return \DateTime
     */
    public function getDateRegistration()
    {
        return $this->dateRegistration;
    }

    /**
     * @return mixed
     */
    public function getJustificatif()
    {
        return $this->justificatif;
    }

    /**
     * @param mixed $justificatif
     */
    public function setJustificatif($justificatif)
    {
        $this->justificatif = $justificatif;
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize(array(
            $this->id
        ));
    }


    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list (
            $this->id
            ) = unserialize($serialized);
    }
}
