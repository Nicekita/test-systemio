<?php

namespace App\Validator\Entity;


use App\Payment\ProcessorPicker;
use App\Repository\CouponRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class EntityExistsValidator extends ConstraintValidator
{
    public function __construct(private EntityManagerInterface $entityManager){}
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof EntityExists) {
            throw new UnexpectedTypeException($constraint, EntityExists::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (empty($constraint->entityClass)) {
            throw new \InvalidArgumentException('EntityExists constraint must have entityClass set.');
        }

        if (empty($constraint->entityName)) {
            throw new \InvalidArgumentException('EntityExists constraint must have entityName set.');
        }

        $entity = $this->entityManager
            ->getRepository($constraint->entityClass)
            ->findOneBy([$constraint->property => $value]);

        if ($entity === null) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ property }}', $constraint->property)
                ->setParameter('{{ value }}', $value)
                ->setParameter('{{ entityName }}', $constraint->entityName)
                ->addViolation();
        }
    }
}