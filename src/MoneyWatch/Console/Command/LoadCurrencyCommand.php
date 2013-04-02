<?php

namespace MoneyWatch\Console\Command;

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
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getHelper('kernel')->getKernel();
        $total = $app['currency_manager']->load($kernel['currency']);
        $output->writeln(sprintf('Done! <info>%d</info> items imported.', $total));
    }
}
