<?php

namespace Places\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResetAccountType extends AbstractType
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
            );
    }
}
