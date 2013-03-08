<?php

use Symfony\Component\Console\Application;
use MoneyWatch\Console\Helper\KernelHelper;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/kernel.php';

$console = new Application('MoneyWatch');
$console->getHelperSet()->set(new KernelHelper($app));

foreach (new DirectoryIterator(__DIR__ . '/../src/MoneyWatch/Console/Command') as $filepath) {
    /* @var $filepath \SplFileInfo */
    if ($filepath->isDot() || $filepath->getExtension() !== 'php') {
        continue;
    }
    if (substr($filepath->getBasename(), -11, 7) === 'Command') {
        $className = 'MoneyWatch\\Console\\Command\\' . substr($filepath->getBasename(), 0, -4);
        $console->add(new $className);
    }
}

$console->run();
