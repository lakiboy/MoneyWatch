<?php

namespace MoneyWatch\Model;

class Rule
{
    private $code;
    private $comparison;
    private $value;

    /**
     * @param string $code
     * @param string $comparison
     * @param number $value
     */
    public function __construct($code, $comparison = null, $value = null)
    {
        $this->code = $code;
        $this->comparison = $comparison;
        $this->value = $value;
    }

    /**
     * Returns True when comparison is now specified.
     *
     * @return boolean
     */
    public function isDailyUpdate()
    {
        return $this->comparison ? false : true;
    }

    /**
     * @param string $rule
     *
     * @return boolean
     */
    public function isRule($rule)
    {
        return constant('MoneyWatch\\Model\\Comparison::' . strtoupper($rule)) === $this->comparison;
    }

    public function getCode()
    {
        return $this->code;
    }

    /**
     * Checkes if supplied currency rate matches the rule.
     *
     * @param Rate $rate
     *
     * @return boolean
     */
    public function matches(Rate $rate)
    {
        if ($rate->getCode() !== $this->code) {
            return false;
        }

        if ($this->isDailyUpdate()) {
            return true;
        }

        switch ($this->comparison) {
            case Comparison::EQ:
                $result = $rate->getValue() == $this->value;
                break;
            case Comparison::GT:
                $result = $rate->getValue() > $this->value;
                break;
            case Comparison::GTE:
                $result = $rate->getValue() >= $this->value;
                break;
            case Comparison::LT:
                $result = $rate->getValue() < $this->value;
                break;
            case Comparison::LTE:
                $result = $rate->getValue() <= $this->value;
                break;
            case Comparison::NEQ:
                $result = $rate->getValue() != $this->value;
                break;
            default:
                $result = false;
        }

        return $result;
    }
}
