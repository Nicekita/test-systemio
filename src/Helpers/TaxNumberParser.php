<?php

namespace App\Helpers;

class TaxNumberParser
{

    public string $countryCode;
    public string $taxNumber;

    public function getCountryCode(string $taxNumber): string
    {
        return substr($taxNumber, 0, 2);
    }

    public function getTaxNumber(string $taxNumber): string
    {
        return substr($taxNumber, 2);
    }

}