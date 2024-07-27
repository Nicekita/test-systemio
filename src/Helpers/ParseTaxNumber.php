<?php

namespace App\Helpers;

class ParseTaxNumber
{

    public string $countryCode;
    public string $taxNumber;

    public function __construct($value)
    {
        $this->countryCode = substr($value, 0, 2);
        $this->taxNumber = substr($value, 2);
    }

}