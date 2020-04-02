<?php

namespace Corohelp\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',
                EmailType::class,
                [
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'authentication.email',
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter an email',
                        ]),
                    ],
                ]
            )
            ->add('password',
                PasswordType::class, [
                    'required' => true,
                    'mapped' => false,
                    'attr' => [
                        'placeholder' => 'authentication.password',
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter a password',
                        ]),
                    ],
                ])
            ->add('_remember_me',
                CheckboxType::class, [
                    'required' => false,
                ]
            )
            ->add('_csrf_token',
                HiddenType::class);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
