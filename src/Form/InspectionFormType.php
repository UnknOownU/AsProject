<?php

namespace App\Form;

use App\Entity\InspectionForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InspectionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $carOptions): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('phone', TextType::class, [
                'label' => 'Téléphone',
            ])
            ->add('carModel', TextType::class, [
                'label' => 'Modèle de voiture',
            ])
            ->add('carBrand', TextType::class, [
                'label' => 'Marque de voiture',
            ])
            ->add('licensePlate', TextType::class, [
                'label' => 'Plaque d\'immatriculation',
            ])
            ->add('fuelType', ChoiceType::class, [
                'label' => 'Choisir l\'énergie',
                'choices' => [
                    'Essence' => 'Essence',
                    'Diesel' => 'Diesel',
                    'Hybride / Electricité' => 'Hybride / Electricité',
                ],
            ])
            ->add('carType', ChoiceType::class, [
                'label' => 'Catégorie',
                'choices' => [
                    'Véhicule particulier' => 'VP',
                    'Véhicule particulier 4x4' => '4x4',
                    'Utilitaire' => 'Util',
                    'Utilitaire 4x4' => 'Util 4x4',
                    'Véhicule spécifique' => 'Vspe',
                    'Camping car' => 'C-car',
                    'Véhicule de collection' => 'Collec',
                    'Cyclo / Scooter' => 'Cyclo',
                    'Moto' => 'Moto',
                    'Quad' => 'Quad',
                    'Voiturette' => 'Voiturette',
                ],
            ])
            ->add('controlType', ChoiceType::class, [
                'label' => 'Choisir un type de contrôle',
                'choices' => [
                    'Contrôle technique réglementaire' => 'CTP',
                    'Visite complémentaire pollution' => 'CC Pol',
                    'Contrôle volontaire complet' => 'Vol Comp',
                    'Contrôle volontaire partiel' => 'Vol Part',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InspectionForm::class,
        ]);
    }
}
