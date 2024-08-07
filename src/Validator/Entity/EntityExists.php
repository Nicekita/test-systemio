<?php

namespace App\Validator\Entity;

use App\Validator\AttributeConstraint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

#[\Attribute]
class EntityExists extends AttributeConstraint
{

    public string $entityClass;
    public string $entityName;
    public string $property;
    public function __construct(string $entityClass,
                                string $entityName,
                                ?string $property = 'id',
                                ?string $message = '{{ entityName }} with {{ property }} {{ value }} does not exist.',
                                ?array $groups = null,
                                string $mode = 'strict',
                                array $options = [])
    {
        parent::__construct($mode, $message, $groups, $options);

        $this->message = $message;
        $this->entityClass = $entityClass;
        $this->entityName = $entityName;
        $this->property = $property;
    }
}