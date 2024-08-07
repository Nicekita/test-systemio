<?php

namespace App\Validator\PaymentProcessor;


use App\Payment\ProcessorPicker;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class PaymentProcessorValidator extends ConstraintValidator
{
    public function __construct(private readonly ProcessorPicker $processorPicker){}
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof PaymentProcessor) {
            throw new UnexpectedTypeException($constraint, PaymentProcessor::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        if (!in_array($value, $this->processorPicker->getAvailableProcessors())) {
            $this->context->buildViolation('Choose a valid payment processor.')
                ->addViolation();
        }


    }
}