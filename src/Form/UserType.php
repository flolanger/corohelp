<?php

namespace Places\Form;

use Places\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',
                EmailType::class,
                [
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'register.email',
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter an email',
                        ]),
                        new Email([
                            'message' => 'Please enter a valid email',
                        ]),
                    ],
                ]
            )
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'The password fields must match.',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'first_options' => ['attr' => ['placeholder' => 'register.password']],
                'second_options' => ['attr' => ['placeholder' => 'register.passwordRepeat']],
            ])
            ->add(
                'name',
                TextType::class,
                [
                    'required' => false,
                    'empty_data' => '',
                ]
            )
            ->add(
                'location',
                TextType::class,
                [
                    'required' => false,
                    'empty_data' => '',
                ]
            )
            ->add(
                'phoneNumber',
                TextType::class,
                [
                    'required' => false,
                    'empty_data' => '',
                ]
            )
            ->add(
                'role',
                ChoiceType::class,
                [
                    'label' => 'user.role',
                    'choices' => [
                        'user.roles.user' => 'ROLE_USER',
                        'user.roles.admin' => 'ROLE_ADMIN',
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
