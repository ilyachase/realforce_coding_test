<?php
declare(strict_types=1);

namespace App\Application\Exceptions;

use Throwable;

class InvalidInputException extends \Exception
{
    public function __construct($message = "Invalid input data.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}