<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
#[\Attribute]
class ProductExists extends Constraint
{
    public string $message = 'Товара с ID "{{ id }}" не существует.';
    public string $mode = 'strict';

    public function __construct(?string $mode = null, ?string $message = null, ?array $groups = null, $payload = null)
    {
        parent::__construct([], $groups, $payload);
        //TODO: Передлать с товара на модель(entity/repository) как параметр. Поле тоже. Почистить от лишних параметров
    }
}