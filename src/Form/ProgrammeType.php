<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Programme;
use App\Entity\Session;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dureeModule', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])

            ->add('module', EntityType::class, [
                'class' => Module::class,
                'choice_label' => 'id',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Programme::class,
        ]);
    }
}
