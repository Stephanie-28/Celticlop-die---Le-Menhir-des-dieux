<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Dieu;
use App\Entity\Music;
use App\Entity\Mythe;
use App\Entity\Pantheons;
use App\Entity\Symbole;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('title')
            ->add('description')
            ->add('quote')
            ->add('img')
            ->add('pantheons', EntityType::class, [
                'class' => Pantheons::class,
                'choice_label' => 'title',
                'multiple' => true,
                'required' => false,
            ])
            ->add('symboles', EntityType::class, [
                'class' => Symbole::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false,
            ])
            ->add('animaux', EntityType::class, [
                'class' => Animal::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false,
            ])
            ->add('mythes', EntityType::class, [
                'class' => Mythe::class,
                'choice_label' => 'title',
                'multiple' => true,
                'required' => false,
            ])
            ->add('music', EntityType::class, [
                'class' => Music::class,
                'choice_label' => 'title',
                'placeholder' => 'Aucune musique',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dieu::class,
        ]);
    }
}
