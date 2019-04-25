<?php

namespace AppBundle\Form;

use StoreBundle\StoreBundle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', 'text', array('label' => "Prénom"));
        $builder->add('lastName', 'text', array('label' => "Nom"));
        $builder->add('email', 'email', array('label' => "Email"));
        $builder->add('message', 'textarea', array('label' => "Message"));
    }
    
    public function getName()
    {
        return 'contact_form';
    }



}
