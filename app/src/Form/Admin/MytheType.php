<?php

namespace App\Form\Admin;

use App\Entity\Dieu;
use App\Entity\Mythe;
use App\Enum\MytheCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class MytheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre', 'constraints' => [new NotBlank(), new Length(max: 255)]])
            ->add('content', TextareaType::class, ['label' => 'Récit', 'attr' => ['rows' => 12], 'constraints' => [new NotBlank()]])
            ->add('category', EnumType::class, ['class' => MytheCategory::class, 'label' => 'Catégorie', 'choice_label' => static fn (MytheCategory $category): string => $category->value])
            ->add('img', TextType::class, ['label' => 'Fichier image', 'required' => false])
            ->add('createdAt', DateTimeType::class, ['label' => 'Date de création', 'widget' => 'single_text', 'input' => 'datetime_immutable'])
            ->add('dieux', EntityType::class, ['class' => Dieu::class, 'choice_label' => 'name', 'label' => 'Divinités associées', 'multiple' => true, 'by_reference' => false, 'required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Mythe::class]);
    }
}
