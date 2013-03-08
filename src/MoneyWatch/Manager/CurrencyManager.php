<?php

namespace MoneyWatch\Manager;

use Doctrine\DBAL\Connection;

class CurrencyManager
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
     * @return array
     */
    public function findAll()
    {
        $result = $this->db->fetchAll('SELECT code FROM currency ORDER BY code ASC');

        return array_map(function($v) { return $v['code']; }, $result);
    }
}
