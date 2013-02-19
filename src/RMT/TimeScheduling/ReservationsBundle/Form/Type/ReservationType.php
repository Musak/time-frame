<?php

namespace RMT\TimeScheduling\ReservationsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('reserver', 'model', array(
            'class' => 'FOS\UserBundle\Propel\User',
        ));
        $builder->add('day', 'model', array(
            'class' => 'RMT\TimeScheduling\Model\Day',
        ));
        $builder->add('start_time');
        $builder->add('end_time');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RMT\TimeScheduling\Model\Reservation',
        ));
    }

    public function getName()
    {
        return 'reservation';
    }
}
