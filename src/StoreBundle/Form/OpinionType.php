<?php

namespace StoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class OpinionType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', 'text', array('label' => "Nom"));
        $builder->add('comment', 'textarea',   array('attr' => array('rows' => '3') , 'label' => 'Votre avis'));

    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'StoreBundle\Entity\Opinion'
        );
    }
    public function getName()
    {
        return 'comment_form';
    }

}
