<?php

namespace MoneyWatch\Manager;

use MoneyWatch\Model\Rate;
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
     * @param array $data
     *
     * @return number
     */
    public function load(array $data)
    {
        $total = 0;

        $this->db->transactional(function (Connection $db) use ($data, &$total) {
            foreach ($data as $code => $enabled) {
                if ($enabled) {
                    $db->insert('currency', array('code' => $code));
                    $total++;
                }
            }
        });

        return $total;
    }

    /**
     * @param array  $data
     * @param string $date
     *
     * @return number
     */
    public function loadExchangeData(array $data, $date)
    {
        $this->db->transactional(function (Connection $db) use ($data, $date) {
            $query = 'REPLACE INTO currency_exchange (code, date_posted, rate) VALUES (?, ?, ?)';
            foreach ($data as $code => $rate) {
                $db->executeQuery($query, array($code, $date, $rate));
            }
        });

        return count($data);
    }

    /**
     * @param string|\DateTime $date
     *
     * @return array
     */
    public function findExchangeRatesByDate($date)
    {
        $date = $date instanceof \DateTime ? $date->format('Y-m-d') : $date;
        $data = $this->db->fetchAll('SELECT code, rate FROM currency_exchange WHERE date_posted = ?', array($date));

        $result = array();
        foreach ($data as $item) {
            $result[$item['code']] = new Rate($item['code'], $item['rate']);
        }

        return $result;
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
