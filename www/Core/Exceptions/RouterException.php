<?php


namespace App\Core\Exceptions;

use Throwable;

class RouterException extends \Exception {
    public function __construct($message = "", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}