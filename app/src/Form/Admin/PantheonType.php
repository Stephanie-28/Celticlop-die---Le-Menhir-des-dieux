<?php

namespace App\Form\Admin;

use App\Entity\Dieu;
use App\Entity\Pantheons;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class PantheonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Nom du panthéon', 'constraints' => [new NotBlank(), new Length(max: 255)]])
            ->add('description', TextareaType::class, ['label' => 'Description', 'attr' => ['rows' => 8], 'constraints' => [new NotBlank()]])
            ->add('img', TextType::class, ['label' => 'Fichier image', 'required' => false, 'help' => 'Nom du fichier déjà présent dans les ressources du projet.'])
            ->add('dieux', EntityType::class, ['class' => Dieu::class, 'choice_label' => 'name', 'label' => 'Divinités associées', 'multiple' => true, 'by_reference' => false, 'required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Pantheons::class]);
    }
}
