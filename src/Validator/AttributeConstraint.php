<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

abstract class AttributeConstraint extends Constraint
{
    public string $mode = 'strict';
    public string $message = '';

    public function __construct(?string $mode = null, ?string $message = null, ?array $groups = null, $payload = null)
    {
        parent::__construct([], $groups, $payload);
    }
}