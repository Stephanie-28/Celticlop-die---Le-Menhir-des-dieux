<?php

namespace App\Form\Admin;

use App\Entity\Animal;
use App\Entity\Dieu;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom de l’animal', 'constraints' => [new NotBlank(), new Length(max: 255)]])
            ->add('description', TextareaType::class, ['label' => 'Description', 'attr' => ['rows' => 8], 'constraints' => [new NotBlank()]])
            ->add('img', TextType::class, ['label' => 'Fichier image', 'required' => false])
            ->add('dieux', EntityType::class, ['class' => Dieu::class, 'choice_label' => 'name', 'label' => 'Divinités associées', 'multiple' => true, 'by_reference' => false, 'required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Animal::class]);
    }
}
