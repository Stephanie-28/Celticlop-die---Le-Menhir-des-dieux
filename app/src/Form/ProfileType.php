<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                'label' => 'Nom d’Initié',
                'constraints' => [
                    new NotBlank(message: 'Choisis un nom d’Initié.'),
                    new Length(min: 2, max: 100),
                ],
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'required' => false,
                'constraints' => [new Length(max: 100)],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'required' => false,
                'constraints' => [new Length(max: 100)],
            ])
            ->add('motto', TextareaType::class, [
                'label' => 'Devise personnelle',
                'required' => false,
                'constraints' => [new Length(max: 100, maxMessage: 'Ta devise ne peut pas dépasser {{ limit }} caractères.')],
                'attr' => ['rows' => 3, 'maxlength' => 100],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail',
                'constraints' => [
                    new NotBlank(message: 'Indique ton adresse e-mail.'),
                    new Email(message: 'Cette adresse e-mail n’est pas valide.'),
                    new Length(max: 180),
                ],
            ])
            ->add('avatarFile', FileType::class, [
                'label' => 'Nouvel avatar',
                'mapped' => false,
                'required' => false,
                'help' => 'JPEG, PNG ou WebP — 2 Mo maximum.',
                'attr' => ['accept' => 'image/jpeg,image/png,image/webp'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
