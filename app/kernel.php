<?php

use MoneyWatch\Provider\ManagerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\DoctrineServiceProvider;

require_once __DIR__ . '/../vendor/autoload.php';

$config = parse_ini_file(__DIR__ . '/Resources/config/parameters.ini', true);

$app = new Silex\Application();
$app->register(new DoctrineServiceProvider(), array(
    'dbs.options' => array('default' => $config['database'])
));
$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/Resources/views',
    'twig.options' => array('cache' => __DIR__ . '/cache/twig')
));
$app->register(new FormServiceProvider(), array(
    'form.secret' => $config['form']['secret']
));
$app->register(new TranslationServiceProvider(), array(
    'locale_fallback' => 'en'
));
$app->register(new ValidatorServiceProvider());
$app->register(new SessionServiceProvider());
$app->register(new ManagerServiceProvider());

$app['currency'] = $config['currency'];
$app['options'] = $config['app'];

return $app;
