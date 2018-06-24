<?php
// src/AppBundle/Form/ContactType.php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomcomplet', TextType::class, 
                array(
                'label' => 'Nom complet',
                'constraints' => array(
                    new Length(array("min" => 2,
                                     "max" => 50,
                                     "minMessage" => "Il faut 2 caractères minimum",
                                     "maxMessage" => "Il faut 50 caractères maximum"
                                     )),
                    new NotBlank(array("message" => "Ce champ est obligatoire")),
            )))
            ->add('email', EmailType::class,
                array(
                'label' => 'Email',
                'constraints' => array(
                    new NotBlank(array("message" => "Ce champ est obligatoire")),
                    new Email(array("message" => "Ceci n’est pas une adresse email valide")),
                )
            ))
            ->add('objet',   TextType::class, 
                array(
                'label' => 'Objet',
                'constraints' => array(
                    new Length(array("min" => 2,
                                     "minMessage" => "Il faut 2 caractères minimum",
                                     "max" => 50,
                                     "maxMessage" => "Il faut 50 caractères maximum"
                                     )),
                    new NotBlank(array("message" => "Ce champ est obligatoire"))
            )))
            ->add('message',            TextareaType::class, 
                array(
                'label' => 'Message',
                'constraints' => array(
                    new Length(array("min" => 20,
                                     "minMessage" => "Il faut 20 caractères minimum",
                                     "max" => 500,
                                     "maxMessage" => "Il faut 5000 caractères maximum"
                                     )),
                    new NotBlank(array("message" => "Ce champ est obligatoire"))     
            )))
        ;
    }
}

