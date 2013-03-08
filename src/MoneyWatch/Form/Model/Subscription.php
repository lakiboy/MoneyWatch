<?php

namespace MoneyWatch\Form\Model;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Subscription
{
    private $currency;
    private $email;
    private $comparison;
    private $value;

    public function __construct($currency = null)
    {
        $this->setCurrency($currency);
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getComparison()
    {
        return $this->comparison;
    }

    public function setComparison($comparison)
    {
        $this->comparison = $comparison;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('currency', new Assert\NotBlank());
        $metadata->addPropertyConstraint('email', new Assert\NotBlank());
        $metadata->addPropertyConstraint('email', new Assert\Email());
    }
}
