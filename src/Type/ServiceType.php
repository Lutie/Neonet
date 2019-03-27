<?php

namespace App\Type;

use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du service',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('price', IntegerType::class, [
                'label' => 'Prix (en €)',
            ])
            ->add('service', EntityType::class, [
                'label' => 'Service parent',
                'class' => Service::class,
                'required' => false,
                'choice_label' => function (Service $service) {
                    return sprintf('%s',$service->getName());
                }
            ]);
    }
}