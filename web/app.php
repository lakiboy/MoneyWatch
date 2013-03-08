<?php

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use MoneyWatch\Form\Model\Subscription;
use MoneyWatch\Form\Type\SubscribeType;

require_once __DIR__ . '/../app/kernel.php';

/* @var $app \Silex\Application */
$app['debug'] = true;

$app->match('/', function (Request $request) use ($app) {
    /* @var $factory \Symfony\Component\Form\FormFactory */
    $factory = $app['form.factory'];
    $form = $factory->create(new SubscribeType($app));

    if ($request->isMethod('POST')) {
        if ($form->bind($request)->isValid()) {
            $app['subscription_manager']->subscribe($form->getData());

            return new RedirectResponse('/');
        }
    } else {
        $form->setData(new Subscription($app['options']['default_currency']));
    }

    return $app['twig']->render('index.html.twig', array(
        'form' => $form->createView()
    ));
});

$app->run();
