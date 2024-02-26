<?php

namespace App\Util;

use App\Exception\UnknownCurrencyException;


class Calculator
{
    public function add($n1, $n2)
    {
        return $n1 + $n2;
    }

    public function subtract($n1, $n2)
    {
        return $n1 - $n2;
    }

    public function divide($n, $divisor)
    {
        if(empty($divisor)){
            throw new \InvalidArgumentException("Divisor must be a number");
        }

        return $n / $divisor;
    }

    public function euroOnlyExchange(string $currency)
    {
        $currency = strtolower($currency);
        if('euro' != $currency){
            throw new UnknownCurrencyException();
        }

        // other logic here ...
    }
}