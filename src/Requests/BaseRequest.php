<?php

namespace App\Requests;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseRequest
{
    // Здесь я немного решил за оверинжинирить, ибо в ларавель примерно такой API для валидации запросов, и я его эмулирую здесь
    public function __construct(protected ValidatorInterface $validator)
    {
        foreach (Request::createFromGlobals()->toArray() as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
        $errors = $this->validate();

        if (count($errors) > 0) {

            $errors = array_map(function ($error) {
                return $error->getMessage();
            }, iterator_to_array($errors));

            $response = new JsonResponse(['errors' => $errors], 400);
            $response->send();
            exit();
        }
    }

    public function validate(): ConstraintViolationListInterface
    {
        return $this->validator->validate($this);
    }
}