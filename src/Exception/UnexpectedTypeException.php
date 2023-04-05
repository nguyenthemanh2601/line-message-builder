<?php

namespace ManhNt\Exception;

class UnexpectedTypeException extends \RuntimeException
{
    /**
     * @param  mixed  $value
     * @param  string $expectedType
     */
    public function __construct($value, $expectedType)
    {
        parent::__construct(sprintf('Expected argument of type %s, %s given', $expectedType, gettype($value)));
    }
}
