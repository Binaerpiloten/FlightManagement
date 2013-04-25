<?php

namespace NilsWisiol\FlightManagementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CaptainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        		->add('id') // TODO make sure id doesnt get ever changed
            ->add('name')
            ->add('birthday')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NilsWisiol\FlightManagementBundle\Entity\Captain',
        		'csrf_protection' => false,
        ));
    }

    public function getName()
    {
        return '';
    }
}
