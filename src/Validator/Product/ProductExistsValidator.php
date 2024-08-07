<?php

namespace App\Validator\Product;

use App\Repository\ProductRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ProductExistsValidator extends ConstraintValidator
{
    public function __construct(private readonly ProductRepository $productRepository){}
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof ProductExists) {
            throw new UnexpectedTypeException($constraint, ProductExists::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_int($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }



        if ($this->productRepository->findById($value)) {
            return;
        }
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ id }}', $value)
            ->addViolation();
    }
}