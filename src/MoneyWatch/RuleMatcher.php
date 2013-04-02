<?php

namespace MoneyWatch;

use MoneyWatch\Model\RuleMatch;

class RuleMatcher
{
    private $rates;

    /**
     * @param \MoneyWatch\Model\Rate[] $rates
     */
    public function __construct(array $rates)
    {
        $this->rates = $rates;
    }

    /**
     * Iterates through given rules and check if any matches given currency rate.
     *
     * @param \MoneyWatch\Model\Rule[] $rules
     *
     * @return \MoneyWatch\Model\RuleMatch[]
     */
    public function match(array $rules)
    {
        $result = array();

        foreach ($rules as $rule) {
            $rate = $this->rates[$rule->getCode()];
            if ($rule->matches($rate)) {
                $result[] = new RuleMatch($rate, $rule);
            }
        }

        return $result;
    }
}
