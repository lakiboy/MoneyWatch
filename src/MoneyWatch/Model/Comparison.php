<?php

namespace MoneyWatch\Model;

/**
 * Available compare methods.
 */
final class Comparison
{
    const EQ  = '=';
    const NEQ = '<>';
    const LT  = '<';
    const LTE = '<=';
    const GT  = '>';
    const GTE = '>=';

    private function __construct()
    {
    }
}
