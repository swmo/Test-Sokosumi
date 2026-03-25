<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titel',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Titel des Einsatzes'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Beschreibung',
                'required' => false,
                'attr' => ['class' => 'form-control', 'rows' => 5, 'placeholder' => 'Beschreibung des Einsatzes'],
            ])
            ->add('location', TextType::class, [
                'label' => 'Ort',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Veranstaltungsort'],
            ])
            ->add('date', DateTimeType::class, [
                'label' => 'Datum und Uhrzeit',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('maxParticipants', IntegerType::class, [
                'label' => 'Maximale Teilnehmerzahl',
                'attr' => ['class' => 'form-control', 'min' => 1, 'placeholder' => 'Max. Teilnehmer'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
