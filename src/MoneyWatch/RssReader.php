<?php

namespace MoneyWatch;

/**
 * Read currency data from RSS.
 */
class RssReader
{
    private $url;

    /**
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @return array
     *
     * @throws \RuntimeException
     */
    public function parse()
    {
        $old = libxml_use_internal_errors(true);
        $xml = simplexml_load_file($this->url);

        if (false !== ($error = libxml_get_last_error())) {
            throw new \RuntimeException('XML parse error: ' . $error->message);
        }

        libxml_use_internal_errors($old);

        $result = array();
        foreach ($xml->channel->item as $item) {
            $result[$this->toMachineDate((string) $item->pubDate)] = $this->extractCurrencyData((string) $item->description);
        }

        return $result;
    }

    private function toMachineDate($string)
    {
        $d = new \DateTime($string);

        return $d->format('Y-m-d');
    }

    private function extractCurrencyData($string)
    {
        $result = array();

        $prev = null;
        foreach (explode(' ', $string) as $i => $v) {
            if ($i % 2 == 1) {
                $result[$prev] = $v;
            } else {
                $prev = $v;
            }
        }

        return $result;
    }
}
