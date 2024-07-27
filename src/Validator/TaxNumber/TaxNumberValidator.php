<?php

namespace App\Validator\TaxNumber;

use App\Helpers\ParseTaxNumber;
use App\Repository\CountryRepository;
use App\Repository\ProductRepository;
use App\Validator\Product\TaxNumber;
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

        //Тут код сильно зависит от того, ограничен ли код страны двумя символами.

        $taxNumber = new ParseTaxNumber($value);

        $countryCode = $taxNumber->countryCode;
        $taxNumber = $taxNumber->taxNumber;

        //Получаем из ещё не существующего репозитория страну по коду
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
            //TODO: Проверить количество символов и цифр отдельно?
            // Надо уточнить, насколько сложная должна быть проверка

            $this->context->buildViolation('Wrong tax number format.')
                ->addViolation();
        }


    }
}