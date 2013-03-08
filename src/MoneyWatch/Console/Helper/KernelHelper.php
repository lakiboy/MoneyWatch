<?php

namespace MoneyWatch\Console\Helper;

use Silex\Application;
use Symfony\Component\Console\Helper\Helper;

class KernelHelper extends Helper
{
    private $kernel;

    public function __construct(Application $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @return Application
     */
    public function getKernel()
    {
        return $this->kernel;
    }

    public function getName()
    {
        return 'kernel';
    }
}
