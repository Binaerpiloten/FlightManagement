<?php

namespace NilsWisiol\FlightManagementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FlightType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        		->add('id') // TODO make sure id doesnt get ever changed
            ->add('number')
            ->add('origin')
            ->add('destination')
            ->add('captain', 'entity', array(
            			'class' => 'NilsWisiolFlightManagementBundle:Captain',
            			'property' => 'name',
            		))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NilsWisiol\FlightManagementBundle\Entity\Flight',
        		'csrf_protection' => false,
        ));
    }

    public function getName()
    {
        return '';
    }
}
