<?php

namespace App\Exception;

class UnknownCurrencyException extends \Exception
{
    public function __construct($message = null)
    {
        if(empty($message)) {
            $message = 'Unknown currency';
        }
        parent::__construct($message);
    }
}