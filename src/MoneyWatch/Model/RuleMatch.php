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
}
