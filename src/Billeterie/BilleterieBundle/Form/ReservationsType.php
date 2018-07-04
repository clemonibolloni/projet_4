<?php

namespace Billeterie\BilleterieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ReservationsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add('dateDeVisite', DateTimeType::class, [
                'widget' => "single_text",
                'html5' => false,
                'input' => 'datetime',
                'attr' => array('class' => 'date'),
            ])
            ->add('type', ChoiceType::class, array(
                'choices' => array(
                    'Journée' => 'journée',
                    'Demi-journée' => 'demi-journée',)))
            ->add('mail', EmailType::class);

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Billeterie\BilleterieBundle\Entity\Reservations'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'billeterie_billeteriebundle_reservations';
    }

}
