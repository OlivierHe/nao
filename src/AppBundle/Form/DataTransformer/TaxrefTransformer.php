<?php
namespace AppBundle\Form\DataTransformer;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TaxrefTransformer implements DataTransformerInterface
{
    private $repository;

    public function __construct(EntityRepository $repository)
    {
         $this->repository = $repository;
    }


    public function transform($taxref)
    {
        if (null === $taxref) {
            return '';
        }

        return $taxref->getId();
    }


    public function reverseTransform($taxrefNum)
    {
        if (null === $taxrefNum) {
            return null;
        }else{
            $taxref = $this->repository->find($taxrefNum);
        }

        if (null === $taxref) {
            throw new TransformationFailedException(sprintf(
            'An issue with number "%s" does not exist!',
            $taxrefNum
            ));
        }

        return $taxref;
    }
}
