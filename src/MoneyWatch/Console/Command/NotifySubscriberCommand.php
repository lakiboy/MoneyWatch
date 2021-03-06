<?php

namespace MoneyWatch\Console\Command;

use MoneyWatch\Mailer;
use MoneyWatch\RuleMatcher;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;

class NotifySubscriberCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('notify:subscriber')
            ->setDescription('Notify subscriber about currency exchange updates.')
            ->addArgument('email', InputArgument::REQUIRED, 'Email of subscriber.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $output->writeln(sprintf('<error>Invalid email: %s</error>', $email));
        }

        $app = $this->getHelper('kernel')->getKernel();
        if (!$app['subscription_manager']->hasSubscriber($email)) {
            return $output->writeln(sprintf('<error>Subscriber not found: %s</error>', $email));
        }

        $rules = $app['subscription_manager']->getRulesBySubsciber($email);
        $rates = $app['currency_manager']->findExchangeRatesByDate(new \DateTime);

        $matcher = new RuleMatcher($rates);
        $matches = $matcher->match($rules);

        if (!count($matches)) {
            return $output->writeln(sprintf('No matches found for %s', $email));
        }

        $output->writeln(sprintf('Matches found: <info>%d</info>; subscriber: <comment>%s</comment>', count($matches), $email));

        $params = array(
            'from_email' => $app['options']['mailer_from_email'],
            'from_name' => $app['options']['mailer_from_name'],
            'subject' => $app['options']['mailer_subject'],
            'to_email' => $email
        );
        $mailer = new Mailer($app['mailer'], $app['twig']);
        $result = $mailer->send($params, array('matches' => $matches, 'date' => new \DateTime));

        if ($result) {
            $output->writeln('<comment>Notification sent</comment>');
        } else {
            $output->writeln('<error>Failed sending notification</error>');
        }

        // Flush queue.
        $app['swiftmailer.spool']->flushQueue($app['swiftmailer.transport']);
    }
}
