<?php

namespace App\Form;

use App\Entity\Espace;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;

class EspaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('superficie')
            ->add('date_ouverture', DateType::class, [
                'widget' => 'choice',
                'format' => 'dd-MM-yyyy',
            ])
            // if form(dateOuvertu) == 
            // 
            ->add('date_fermeture', DateType::class, [
                'widget' => 'choice',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('ajouter', SubmitType::class, ["label"=>"Ajouter"])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Espace::class,
        ]);
    }
}
