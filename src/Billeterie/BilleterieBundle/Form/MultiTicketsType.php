<?php
/**
 * Created by PhpStorm.
 * User: Clement
 * Date: 18/04/2018
 * Time: 20:41
 */

namespace Billeterie\BilleterieBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MultiTicketsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tickets', CollectionType::class, array(
                'entry_type' => TicketsType::class,
                "entry_options" => array(
                    'label' => "Visiteur"),
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false));
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

}