<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Observation;
use AppBundle\Form\DataTransformer\TaxrefTransformer;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObservationType extends AbstractType
{
    private $repository;

    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('observationDate', DateType::class, array(
                    'widget' => 'single_text','format' => 'd-MM-yyyy',))
                ->add('taxref',HiddenType::class)
                ->add('longitude')
                ->add('latitude')
                ->add('photo', PhotoType::class , array('required' => false));

        $builder->get('taxref')->addModelTransformer(new TaxrefTransformer($this->repository));

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Observation::class
        ));
    }


}
