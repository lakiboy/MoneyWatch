<?php

namespace MoneyWatch\Console\Command;

use MoneyWatch\RssReader;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;

/**
 * Load currency exchnage data into database from bank.lv.
 */
class LoadCurrencyExchangeDataCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('currency:exchange:load')
            ->setDescription('Load currency exchange data.')
            ->addOption('date', null, InputOption::VALUE_OPTIONAL, 'Load data for a particular date.', 'now')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Look for data for this particular date
        $date = new \DateTime($input->getOption('date'));
        $date = $date->format('Y-m-d');

        $data = $this->readData();
        if (!isset($data[$date])) {
            return $output->writeln(sprintf('<error>Unable to read data for "%s"</error>', $date));
        }

        $app = $this->getHelper('kernel')->getKernel();
        $total = $app['currency_manager']->loadExchangeData($data[$date], $date);

        $output->writeln(sprintf('Done! <info>%d</info> items imported.', $total));
    }

    /**
     * Read currency data from RSS.
     *
     * @return array
     */
    private function readData()
    {
        $app = $this->getHelper('kernel')->getKernel();
        $reader = new RssReader($app['options']['rss_url']);

        return $reader->parse();
    }
}
