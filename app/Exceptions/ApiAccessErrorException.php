<?php

namespace App\Exceptions;

class ApiAccessErrorException extends \Exception
{

    private $errors;

    public function __construct(string $message = 'Unknown error!', int $code = 0, array $errors = [])
    {
        parent::__construct($message, $code);
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}