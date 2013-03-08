<?php

namespace MoneyWatch\Manager;

use MoneyWatch\Form\Model\Subscription;
use Doctrine\DBAL\Connection;

class SubscriptionManager
{
    private $db;

    /**
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * @param Subscription $data
     */
    public function subscribe(Subscription $data)
    {
    }
}
