<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\User;
use Doctrine\DBAL\Types\BooleanType;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                'label' => 'Libellé',
                'attr' => [
                    'placeholder' => 'Le titre du projet'
                ]
            ])
            ->add('code', TextType::class, [
                'label' => 'Code',
                'attr' => [
                    'placeholder' => 'code'
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Un court descriptif'
                ]
            ])
            ->add('beginDate', null, [
                'widget' => 'single_text',
            ])
            ->add('endDate', null, [
                'widget' => 'single_text',
            ])
            ->add('estimateEndDate', null, [
                'widget' => 'single_text',
            ])
            ->add('priority', IntegerType::class, [
                'label' => 'Priorité',
                'attr' => [
                    'placeholder' => 'Est-ce un projet prioritaire?'
                ]
            ])
            ->add('cost', IntegerType::class, [
                'label' => 'Coût',
                'attr' => [
                    'placeholder' => 'coût du projet'
                ]
            ])
            ->add('isFinished', null, [
                'label' => 'Terminé'
            ])
            ->add('isSuccess', null, [
                'label' => 'Avec succès'
            ])
            // ->add('user', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            //     'multiple' => true,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
