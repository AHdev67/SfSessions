<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Formateur;
use App\Entity\Formation;
use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intituleSession', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])

            ->add('nbPlaces', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])

            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])

            ->add('dateFin', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])

            ->add('formation', EntityType::class, [
                'class' => Formation::class,
                'choice_label' => 'intituleFormation',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            
            ->add('formateur', EntityType::class, [
                'class' => Formateur::class,
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])

            ->add('valider', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
