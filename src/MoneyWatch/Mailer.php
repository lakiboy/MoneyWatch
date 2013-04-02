<?php

namespace MoneyWatch;

class Mailer
{
    private $mailer;
    private $templating;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * @param array $params
     * @param array $vars
     *
     * @return boolean
     */
    public function send(array $params, array $vars = array())
    {
        $message = \Swift_Message::newInstance()
            ->setFrom($params['from_email'], $params['from_name'])
            ->setTo($params['to_email'])
            ->setSubject($params['subject'])
            ->setBody($body = $this->templating->render('email.html.twig', $vars));
        ;

        return (boolean) $this->mailer->send($message);
    }
}
