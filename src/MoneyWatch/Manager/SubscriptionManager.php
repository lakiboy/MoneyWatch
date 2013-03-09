<?php

namespace MoneyWatch\Manager;

use MoneyWatch\Form\Model\Subscription;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;

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
     *
     * @return ID of subscription
     */
    public function subscribe(Subscription $data)
    {
        $this->ensureEmailExists($data->getEmail());

        return $this->db->insert('subscription', array(
            'email' => $data->getEmail(),
            'currency' => $data->getCurrency(),
            'comparison' => $data->getComparison() ?: null,
            'value' => $data->getValue() ?: null,
            'date_created' => date('Y-m-d H:i:s')
        ));
    }

    /**
     * Ensure each email is saved separately into its own table.
     */
    private function ensureEmailExists($email)
    {
        $email = $this->db->quote($email, Type::STRING);
        $this->db->query("INSERT IGNORE INTO email VALUES ($email)");
    }
}
