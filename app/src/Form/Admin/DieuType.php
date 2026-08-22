<?php

namespace App\Form\Admin;

use App\Entity\Animal;
use App\Entity\Dieu;
use App\Entity\Music;
use App\Entity\Mythe;
use App\Entity\Pantheons;
use App\Entity\Symbole;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class DieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('portraitFile', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Portrait divin',
                'help' => 'JPG, PNG ou WebP — 8 Mo maximum. L’image actuelle est conservée si aucun fichier n’est choisi.',
                'constraints' => [new File(maxSize: '8M', mimeTypes: ['image/jpeg', 'image/png', 'image/webp'], mimeTypesMessage: 'Choisissez une image JPG, PNG ou WebP valide.')],
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom de la divinité',
                'constraints' => [new NotBlank(message: 'Le nom de la divinité est requis.'), new Length(max: 255)],
            ])
            ->add('title', TextType::class, [
                'label' => 'Titre sacré',
                'constraints' => [new NotBlank(message: 'Le titre sacré est requis.'), new Length(max: 255)],
            ])
            ->add('pantheons', EntityType::class, [
                'class' => Pantheons::class,
                'choice_label' => 'title',
                'label' => 'Panthéon / origine',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description sacrée et traditions',
                'attr' => ['rows' => 9],
                'constraints' => [new NotBlank(message: 'La description est requise.')],
            ])
            ->add('quote', TextareaType::class, [
                'label' => 'Parole divine / citation',
                'required' => false,
                'attr' => ['rows' => 3],
            ])
            ->add('symboles', EntityType::class, [
                'class' => Symbole::class,
                'choice_label' => 'name',
                'label' => 'Symboles associés',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('animaux', EntityType::class, [
                'class' => Animal::class,
                'choice_label' => 'name',
                'label' => 'Animaux associés',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('mythes', EntityType::class, [
                'class' => Mythe::class,
                'choice_label' => 'title',
                'label' => 'Mythes associés',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('music', EntityType::class, [
                'class' => Music::class,
                'choice_label' => 'title',
                'label' => 'Musique associée',
                'placeholder' => 'Aucune musique',
                'required' => false,
            ])
            ->add('isVisible', CheckboxType::class, [
                'label' => 'Visible sur le site',
                'required' => false,
            ])
            ->add('sacredLevel', ChoiceType::class, [
                'label' => 'Niveau sacré',
                'help' => 'Le niveau sacré indique la notoriété de la divinité.',
                'invalid_message' => 'Le niveau sacré doit être compris entre 1 et 5.',
                'expanded' => true,
                'choices' => [
                    '★☆☆☆☆ — Très peu connue' => 1,
                    '★★☆☆☆ — Peu connue' => 2,
                    '★★★☆☆ — Moyennement connue' => 3,
                    '★★★★☆ — Connue' => 4,
                    '★★★★★ — Très connue' => 5,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Dieu::class]);
    }
}
