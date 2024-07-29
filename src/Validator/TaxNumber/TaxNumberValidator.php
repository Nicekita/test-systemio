<?php

namespace App\Validator\TaxNumber;

use App\Helpers\ParseTaxNumber;
use App\Repository\CountryRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class TaxNumberValidator extends ConstraintValidator
{
    public function __construct(private readonly CountryRepository $countryRepository){}
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof TaxNumber) {
            throw new UnexpectedTypeException($constraint, TaxNumber::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $taxNumber = new ParseTaxNumber($value);

        $countryCode = $taxNumber->countryCode;
        $taxNumber = $taxNumber->taxNumber;

        $country = $this->countryRepository->findByCode($countryCode);

        if (!$country) {
            $this->context->buildViolation('Payment in country with code "{{ code }}" is not supported.')
                ->setParameter('{{ code }}', $countryCode)
                ->addViolation();
            return;
        }


        $symbolsCount = $country->getSymbols();
        $numbersCount = $country->getNumbers();

        if (strlen($taxNumber) !== $symbolsCount + $numbersCount) {
            // Тут можно накинуть сотни вариантов валидации таксового номера, считать цифры + символы, проверять наличие символов и цифр, проверять наличие пробелов и т.д.
            // Но в рамках задачи я ограничусь проверкой на длину
            $this->context->buildViolation('Wrong tax number format.')
                ->addViolation();
        }


    }
}