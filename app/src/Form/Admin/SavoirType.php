<?php

namespace App\Form\Admin;

use App\Entity\Savoir;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class SavoirType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre', 'constraints' => [new NotBlank(), new Length(max: 255)]])
            ->add('content', TextareaType::class, ['label' => 'Contenu préservé', 'attr' => ['rows' => 12], 'constraints' => [new NotBlank()]])
            ->add('img', TextType::class, ['label' => 'Fichier image', 'required' => false])
            ->add('isFocus', CheckboxType::class, ['label' => 'Mettre ce savoir en lumière', 'required' => false])
            ->add('createdAt', DateTimeType::class, ['label' => 'Date de création', 'widget' => 'single_text', 'input' => 'datetime_immutable']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Savoir::class]);
    }
}
