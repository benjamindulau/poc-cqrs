<?php

namespace Acme\UserBundle\Web\Command\FormType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterCommandFormType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('screenName', null, array('label' => 'registration.form.screenName'))
            ->add('email', null, array('label' => 'registration.form.email'))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'first_options' => array('label' => 'registration.form.password'),
                'second_options' => array('label' => 'registration.form.password_confirmation'),
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\UserBundle\Web\Command\RegisterCommand',
        ));
    }

    public function getName()
    {
        return 'register';
    }
}
