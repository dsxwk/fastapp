<?php

namespace helpers\exception;
use Exception AS E;

class Exception extends E
{
    public $code = 500;

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        http_response_code($this->code);
        parent::__construct($message, $this->code, $previous);
    }
}