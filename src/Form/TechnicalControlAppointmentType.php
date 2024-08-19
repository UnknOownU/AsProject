<?php

namespace App\Form;

use App\Entity\TechnicalControlAppointment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TechnicalControlAppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $step = $options['step'];

        if ($step === 1) {
            $builder->add('carType', ChoiceType::class, [
                'label' => 'Type de véhicule',
                'choices' => [
                    'Véhicule particulier' => 'Véhicule particulier',
                    'Véhicule particulier 4x4' => 'Véhicule particulier 4x4',
                    'Utilitaire' => 'Utilitaire',
                    'Utilitaire 4x4' => 'Utilitaire 4x4',
                    'Véhicule spécifique' => 'Véhicule spécifique',
                    'Camping car' => 'Camping car',
                    'Véhicule de collection' => 'Véhicule de collection',
                    'Utilitaire caisse grand volume' => 'Utilitaire caisse grand volume',
                ],
                'expanded' => true,
                'multiple' => false,
                'attr' => ['class' => 'btn-group btn-group-toggle d-flex'],
            ]);
            
        }

        if ($step === 2) {
            $builder->add('fuelType', ChoiceType::class, [
                'label' => 'Type de carburant',
                'choices' => [
                    'Essence' => 'Essence',
                    'Diesel' => 'Diesel',
                    'GPL' => 'GPL',
                    'Hybride / Electricité' => 'Hybride / Electricité',
                ],
                'expanded' => true,
                'multiple' => false,
                'attr' => ['class' => 'btn-group btn-group-toggle d-flex'],
            ]);
        }

        if ($step === 3) {
            $builder->add('controlType', ChoiceType::class, [
                'label' => 'Type de contrôle technique',
                'choices' => [
                    'CTP' => 'CTP',
                    'CV Banc' => 'CV Banc',
                    'CV Vis + Bc 4p' => 'CV Vis + Bc 4p',
                    'CC Pol' => 'CC Pol',
                    'Vol Comp' => 'Vol Comp',
                    'Vol Part' => 'Vol Part',
                ],
                'expanded' => true,
                'multiple' => false,
                'attr' => ['class' => 'btn-group btn-group-toggle d-flex'],
            ]);
        }

        if ($step === 4) {
            $builder
                ->add('firstname', TextType::class, [
                    'label' => 'Prénom',
                    'attr' => ['class' => 'form-control']
                ])
                ->add('lastname', TextType::class, [
                    'label' => 'Nom',
                    'attr' => ['class' => 'form-control']
                ])
                ->add('email', EmailType::class, [
                    'label' => 'Adresse email',
                    'attr' => ['class' => 'form-control']
                ])
                ->add('phone', TextType::class, [
                    'label' => 'Numéro de téléphone',
                    'attr' => ['class' => 'form-control']
                ])
                ->add('carBrand', TextType::class, [
                    'label' => 'Marque de la voiture',
                    'attr' => ['class' => 'form-control']
                ])
                ->add('carModel', TextType::class, [
                    'label' => 'Modèle de la voiture',
                    'attr' => ['class' => 'form-control']
                ])
                ->add('licensePlate', TextType::class, [
                    'label' => 'Immatriculation',
                    'attr' => ['class' => 'form-control']
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TechnicalControlAppointment::class,
            'step' => 1, // Par défaut, on commence par le step 1
        ]);
    }
}
