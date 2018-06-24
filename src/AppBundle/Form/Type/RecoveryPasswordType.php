<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;


//Validators
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

class RecoveryPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options)
    {
        $builder->add('username', EmailType::class, array(
                    'label' => 'Email',
                    'constraints' => array ( 
                          new NotBlank(),
                          new Email()
                          )
                ))
                ->add('birthDate', BirthdayType::class, array(
                    'label' => 'Date de naissance',
                    'widget' => 'single_text',
                    'format' => 'd-MM-yyyy',
                ));
    }
}
