<?php

namespace Blog\Exceptions;

use Throwable;

class CategoryNotFoundException extends \Exception {

    public function __construct($message = "", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}