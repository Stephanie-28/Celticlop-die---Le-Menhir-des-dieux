<?php

namespace App\Form\Admin;

use App\Entity\Chronique;
use App\Entity\Mythe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ChroniqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mythe', EntityType::class, ['class' => Mythe::class, 'choice_label' => 'title', 'label' => 'Mythe associé'])
            ->add('title', TextType::class, ['label' => 'Titre', 'constraints' => [new NotBlank(), new Length(max: 255)]])
            ->add('content', TextareaType::class, ['label' => 'Contenu', 'attr' => ['rows' => 12], 'constraints' => [new NotBlank()]])
            ->add('img', TextType::class, ['label' => 'Fichier image', 'required' => false])
            ->add('publishedAt', DateTimeType::class, ['label' => 'Date de publication', 'widget' => 'single_text', 'input' => 'datetime_immutable']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Chronique::class]);
    }
}
