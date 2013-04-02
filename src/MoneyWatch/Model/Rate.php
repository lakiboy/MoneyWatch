<?php

namespace MoneyWatch\Model;

/**
 * Represents currency rate.
 */
class Rate
{
    private $code;
    private $value;

    /**
     * @param string $code
     * @param number $value
     */
    public function __construct($code, $value)
    {
        $this->code = $code;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return number
     */
    public function getValue()
    {
        return $this->value;
    }
}
