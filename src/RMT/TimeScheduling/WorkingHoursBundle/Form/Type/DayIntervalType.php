<?php

namespace RMT\TimeScheduling\WorkingHoursBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DayIntervalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('day_id');
        $builder->add('start_hour');
        $builder->add('end_hour');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RMT\TimeScheduling\Model\DayInterval',
        ));
    }

    public function getName()
    {
        return 'day_interval';
    }
}
