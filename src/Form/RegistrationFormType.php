<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Vorname',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Vorname'],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nachname',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Nachname'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-Mail-Adresse',
                'attr' => ['class' => 'form-control', 'placeholder' => 'E-Mail-Adresse'],
            ])
            ->add('phone', TelType::class, [
                'label' => 'Telefonnummer',
                'required' => false,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Telefonnummer'],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'first_options' => [
                    'label' => 'Passwort',
                    'attr' => ['class' => 'form-control', 'placeholder' => 'Passwort'],
                ],
                'second_options' => [
                    'label' => 'Passwort wiederholen',
                    'attr' => ['class' => 'form-control', 'placeholder' => 'Passwort wiederholen'],
                ],
                'invalid_message' => 'Die Passwoerter stimmen nicht ueberein.',
                'constraints' => [
                    new NotBlank(['message' => 'Bitte geben Sie ein Passwort ein.']),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Das Passwort muss mindestens {{ limit }} Zeichen lang sein.',
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
