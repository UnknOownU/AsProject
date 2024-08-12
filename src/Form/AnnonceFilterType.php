<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brand', ChoiceType::class, [
                'required' => false,
                'label' => 'Marque',
            ])
            ->add('carname', ChoiceType::class, [
                'required' => false,
                'label' => 'Modèle',
            ])
            ->add('fuel', ChoiceType::class, [
                'required' => false,
                'label' => 'Carburant',
            ])
            ->add('gearbox', ChoiceType::class, [
                'required' => false,
                'label' => 'Boîte de vitesse',
            ])
            ->add('color', ChoiceType::class, [
                'required' => false,
                'label' => 'Couleur',
            ])
            ->add('yearFrom', NumberType::class, [
                'required' => false,
                'label' => 'Année à partir de',
            ])
            ->add('yearTo', NumberType::class, [
                'required' => false,
                'label' => 'Année jusqu\'à',
            ])
            ->add('kilometrageMax', NumberType::class, [
                'required' => false,
                'label' => 'Kilométrage maximum',
            ])
            ->add('priceMin', NumberType::class, [
                'required' => false,
                'label' => 'Prix minimum',
            ])
            ->add('priceMax', NumberType::class, [
                'required' => false,
                'label' => 'Prix maximum',
            ])
            ->add('doors', RangeType::class, [
                'required' => false,
                'label' => 'Nombre de portes',
                'attr' => [
                    'min' => 2,
                    'max' => 5,
                ]
            ])
            ->add('seats', RangeType::class, [
                'required' => false,
                'label' => 'Nombre de sièges',
                'attr' => [
                    'min' => 2,
                    'max' => 7,
                ]
            ])
            ->add('fiscalPower', NumberType::class, [
                'required' => false,
                'label' => 'Puissance fiscale (CV)',
            ])
            ->add('horsePower', NumberType::class, [
                'required' => false,
                'label' => 'Puissance moteur (HP)',
            ])
            ->add('technicalControl', ChoiceType::class, [
                'choices' => [
                    'Tous' => null,
                    'OK' => true,
                    'Non OK' => false,
                ],
                'required' => false,
                'label' => 'Contrôle technique',
            ])
            ->add('firstHand', ChoiceType::class, [
                'choices' => [
                    'Tous' => null,
                    'Oui' => true,
                    'Non' => false,
                ],
                'required' => false,
                'label' => 'Première main',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'method' => 'GET',
        ]);
    }
}
