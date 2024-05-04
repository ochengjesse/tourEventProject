<?php

namespace App\Form;

use App\Entity\TourTable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrudType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('names')
            ->add('contactNumber')
            ->add('eMail')
            ->add('nationality')
            ->add('destination')
            ->add('travelDay')
            ->add('totalDays')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TourTable::class,
        ]);
    }
}
