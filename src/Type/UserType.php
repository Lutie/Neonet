<?php

namespace App\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email de l\'utilisateur',
            ])
            ->add('isAdmin', ChoiceType::class, [
                'choices' => [
                    'Non' => 0,
                    'Oui' => 1
                ],
                'label' => 'Gestionnaire ?',
            ]);
    }
}