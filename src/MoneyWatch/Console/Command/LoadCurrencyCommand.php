<?php

namespace MoneyWatch\Console\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;

/**
 * Load currency information into relevant database table.
 */
class LoadCurrencyCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('currency:load')
            ->setDescription('Load currency codes into database')
            ->addOption('table', null, InputOption::VALUE_OPTIONAL, 'Table name.', 'currency')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = $input->getOption('table');
        $kernel = $this->getHelper('kernel')->getKernel();
        $db = $kernel['db'];

        $total = 0;
        foreach ($kernel['currency'] as $code => $enable) {
            if ($enable) {
                $db->insert($table, array('code' => $code));
                $total++;
            }
        }

        $output->writeln(sprintf('Done! <info>%d</info> items imported.', $total));
    }
}
