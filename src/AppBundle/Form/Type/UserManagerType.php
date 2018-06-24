<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserManagerType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('account',ChoiceType::class,array(
                    'choices'  => array(
                        'Particulier' => 'Particulier',
                        'Naturaliste' => 'Naturaliste' ),
                        'expanded' => true,
                        'multiple' => false ))
                ->add('member', ChoiceType::class,array(
                    'choices'  => array(
                        'Oui' => true,
                        'Non' => false ),
                        'expanded' => true,
                        'multiple' => false ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class
        ));
    }

}
