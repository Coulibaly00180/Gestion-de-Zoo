<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Enclos;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero_identification')
            ->add('nom')
            ->add('date_naissance', DateType::class, [
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
                'required' => true
            ])
            ->add('date_arrivee', DateType::class, [
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                ],
                'required' => true
            ])
            ->add('proprietaire')
            ->add('genre')
            ->add('espece')
            ->add('sterilise')
            ->add('quarantaine')
            ->add('enclos', EntityType::class, [
                'class' => Enclos::class,
                'choice_label' => 'nom',
                'multiple' => false,
                'expanded' => false
            ])
            ->add('ok', SubmitType::class, ["label" => "OK"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
