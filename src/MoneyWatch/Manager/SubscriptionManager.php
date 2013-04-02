<?php

namespace MoneyWatch\Manager;

use MoneyWatch\Model\Rule;
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
     * @param string $email
     *
     * @return boolean
     */
    public function hasSubscriber($email)
    {
        $result = $this->db->fetchColumn('SELECT email FROM subscription WHERE email = ?', array($email));

        return $result !== false ? true : false;
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
     * @param string $email
     *
     * @return array
     */
    public function getRulesBySubsciber($email)
    {
        $query = '
            SELECT   currency, comparison, value
            FROM     subscription
            WHERE    email = ?
            ORDER BY date_created ASC
        ';
        $data = $this->db->fetchAll($query, array($email));

        $rules = array();
        foreach ($data as $item) {
            $rules[] = new Rule($item['currency'], $item['comparison'], $item['value']);
        }

        return $rules;
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
