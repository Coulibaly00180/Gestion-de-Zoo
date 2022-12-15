<?php

namespace App\Form;

use App\Entity\Animal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalSupprimerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero_identification')
            ->add('nom')
            ->add('date_naissance')
            ->add('date_arrivee')
            ->add('proprietaire')
            ->add('genre')
            ->add('espece')
            ->add('sterilise')
            ->add('quarantaine')
            ->add('enclos')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
