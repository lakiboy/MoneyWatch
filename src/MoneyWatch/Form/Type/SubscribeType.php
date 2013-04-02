<?php

namespace MoneyWatch\Form\Type;

use MoneyWatch\Model\Comparison;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class SubscribeType extends AbstractType
{
    private $container;

    /**
     * @param \Pimple $container
     */
    public function __construct(\Pimple $container)
    {
        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('currency', 'choice', array('choices' => $options['currency'], 'empty_value' => 'Select currency'))
            ->add('email', 'email', array('attr' => array('placeholder' => 'Type in your email')))
            ->add('comparison', 'choice', array('required' => false, 'choices' => array(
                '' => 'Daily updates',
                Comparison::EQ => 'Equal to',
                Comparison::GT => 'Greater than',
                Comparison::GTE => 'Greater or equal to',
                Comparison::LT => 'Less than',
                Comparison::LTE => 'Less or equal to',
                Comparison::NEQ => 'Not equal to'
            )))
            ->add('value', 'number', array('required' => false, 'attr' => array('placeholder' => 'Input currency exchange value')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $container = $this->container;

        $resolver->setDefaults(array(
            'data_class' => 'MoneyWatch\\Form\\Model\\Subscription',
            'service' => 'currency_manager',
            'currency' => function(Options $options) use ($container) {
                $result = $container[$options['service']]->findAll();

                return array_combine($result, $result);
            }
        ));
    }

    public function getName()
    {
        return 'subscribe';
    }
}
