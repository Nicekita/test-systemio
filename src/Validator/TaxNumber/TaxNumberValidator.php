<?php

namespace App\Validator\TaxNumber;

use App\Helpers\TaxNumberParser;
use App\Repository\CountryRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class TaxNumberValidator extends ConstraintValidator
{
    public function __construct(private readonly CountryRepository $countryRepository, private TaxNumberParser $taxParser){}
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof TaxNumber) {
            throw new UnexpectedTypeException($constraint, TaxNumber::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $countryCode = $this->taxParser->getCountryCode($value);
        $taxNumber = $this->taxParser->getTaxNumber($value);

        $country = $this->countryRepository->findByCode($countryCode);

        if (!$country) {
            $this->context->buildViolation('Payment in country with code "{{ code }}" is not supported.')
                ->setParameter('{{ code }}', $countryCode)
                ->addViolation();
            return;
        }

        $symbolsCount = $country->getSymbols();
        $numbersCount = $country->getNumbers();

        $symbols = substr($taxNumber, 0, $symbolsCount);
        $numbers = substr($taxNumber, $symbolsCount);

        $isSymbolsValid = preg_match('/[a-zA-Z]/', $symbols);
        $isNumbersValid = preg_match('/[0-9]/', $numbers);
        $isEnoughSymbols = strlen($symbols) === $symbolsCount;
        $isEnoughNumbers = strlen($numbers) === $numbersCount;

        if (!$isSymbolsValid || !$isNumbersValid || !$isEnoughSymbols || !$isEnoughNumbers) {
            $this->context->buildViolation('Wrong tax number format.')
                ->addViolation();
        }


    }
}