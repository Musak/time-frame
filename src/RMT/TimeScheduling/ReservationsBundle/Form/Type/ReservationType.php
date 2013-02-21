<?php

namespace RMT\TimeScheduling\ReservationsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReservationType extends AbstractType
{
    // @todo add distinction ad the propel user type such as in the listings of service providers
    //       the current user does not appear in the listing
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('service_provider', 'model', array(
            'class' => 'FOS\UserBundle\Propel\User',
        ));
        $builder->add('day', 'model', array(
            'class' => 'RMT\TimeScheduling\Model\Day',
        ));
        $builder->add('start_time', 'time');
        $builder->add('end_time', 'time');
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
