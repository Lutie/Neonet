<?php

namespace App\Type;

use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du client',
                'attr' => [
                    'placeholder' =>'HOIST GROUP',
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' =>'Parc Silic – Immeuble Axe Seine',
                ]
            ])
            ->add('street', TextType::class, [
                'label' => 'Rue',
                'attr' => [
                    'placeholder' =>'1 rue du 1er Mai',
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' =>'92000 Nanterre',
                ]
            ])
            ->add('code', TextType::class, [
                'label' => 'Code client',
                'attr' => [
                    'placeholder' =>'0014',
                ]
            ])
            ->add('siret', TextType::class, [
                'label' => 'Siret',
                'attr' => [
                    'placeholder' =>'45000000000000',
                ]
            ]);
    }
}