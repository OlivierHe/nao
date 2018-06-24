<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


//Validators

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Email;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('gender', ChoiceType::class, array(
                'label' => 'Sexe',
                'expanded' => true,
                'multiple' => false,
                'choices'  => array(
                'M' => 'Masculin',
                'F' => 'Féminin',
                )))
                ->add('name', TextType::class, array(
                    'label' => 'Nom',
                    'constraints' => array(
                        new NotBlank(),
                        new Type('string'),
                        new Length(array(
                            'min' =>  2,
                            'minMessage' => 'Le nom saisi est trop court !',
                            'max' => 50,
                            'maxMessage' => 'Le nom saisi est trop long',
                        )),
                    ),
                ))
                ->add('firstName', TextType::class, array(
                    'label' => 'Prénom',
                    'constraints' => array(
                        new NotBlank(),
                        new Type('string'),
                        new Length(array(
                            'min' =>  2,
                            'minMessage' => 'Le prénom saisi est trop court !',
                            'max' => 50,
                            'maxMessage' => 'Le prénom saisi est trop long',
                        )),
                    ),
                ))
                ->add('username', EmailType::class, array(
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
                ))
                ->add('pseudo', TextType::class, array(
                    'label' => 'Pseudo',
                    'constraints' => array(
                        new NotBlank(),
                        new Type('string'),
                        new Length(array(
                            'min' =>  3,
                            'minMessage' => 'Le pseudonyme saisi est trop court !',
                            'max' => 20,
                            'maxMessage' => 'Le pseudonyme saisi est trop long',
                        )),
                    ),
                ))
                ->add('password',  RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'invalid_message' => 'Le mot de passe ne correspond pas à celui tappé',
                    'options' => array('attr' => array('class' => 'password-field')),
                    'required' => true,
                    'first_options'  => array('label' => 'Mot de passe'),
                    'second_options' => array('label' => 'Confirmation du mot de passe'),
                    'constraints' => array(
                        new NotBlank(),
                        new Type('string'),
                        new Length(array(
                            'min' =>  8,
                            'minMessage' => 'Le mot de passe saisi est trop court !',
                            'max' => 20,
                            'maxMessage' => 'Le mot de passe saisi est trop long',
                        )),
                    ),
                ))
                ->add('justificatif', PhotoType::class, array(
                    'label' => 'Justificatif',
                    'required' => false
                ))
                ->add('mentionsLegales', CheckboxType::class, array(
                    'required' => true,
                ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }
}
