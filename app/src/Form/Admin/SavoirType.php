<?php

namespace App\Form\Admin;

use App\Entity\Savoir;
use App\Enum\SavoirEditorialType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
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
            ->add('summary', TextareaType::class, ['label' => 'Résumé pour les cartes', 'required' => false, 'attr' => ['rows' => 4], 'constraints' => [new Length(max: 1200)]])
            ->add('content', TextareaType::class, ['label' => 'Contenu long ou texte disponible', 'attr' => ['rows' => 12], 'constraints' => [new NotBlank()]])
            ->add('editorialType', EnumType::class, ['class' => SavoirEditorialType::class, 'label' => 'Type éditorial', 'choice_label' => static fn (SavoirEditorialType $type): string => $type->label()])
            ->add('img', TextType::class, ['label' => 'Fichier image', 'required' => false])
            ->add('isFocus', CheckboxType::class, ['label' => 'Mettre ce savoir en lumière', 'required' => false])
            ->add('createdAt', DateTimeType::class, ['label' => 'Date de création', 'widget' => 'single_text', 'input' => 'datetime_immutable']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Savoir::class]);
    }
}
