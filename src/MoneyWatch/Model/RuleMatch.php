<?php

namespace MoneyWatch\Model;

class RuleMatch
{
    private $rate;
    private $rule;

    /**
     * @param Rate $rate
     * @param Rule $rule
     */
    public function __construct(Rate $rate, Rule $rule)
    {
        $this->rate = $rate;
        $this->rule = $rule;
    }

    /**
     * @return number
     */
    public function getExchnageValue()
    {
        return $this->rate->getValue();
    }

    /**
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->rate->getCode();
    }

    /**
     * @return boolean
     */
    public function isDailyUpdate()
    {
        return $this->rule->isDailyUpdate();
    }

    /**
     * @param string $rule
     *
     * @return boolean
     */
    public function isRule($rule)
    {
        return $this->rule->isRule($rule);
    }
}
