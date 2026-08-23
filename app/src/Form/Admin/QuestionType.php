<?php

namespace App\Form\Admin;

use App\Entity\Question;
use App\Entity\Quiz;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

final class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quiz', EntityType::class, ['class' => Quiz::class, 'choice_label' => 'title', 'label' => 'Quiz associé'])
            ->add('question', TextareaType::class, ['label' => 'Question', 'attr' => ['rows' => 5], 'constraints' => [new NotBlank()]])
            ->add('position', IntegerType::class, ['label' => 'Position', 'constraints' => [new Positive(message: 'La position doit être supérieure à zéro.')]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Question::class]);
    }
}
