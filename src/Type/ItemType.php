<?php

namespace App\Type;

use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'option',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('price', IntegerType::class, [
                'label' => 'Prix (en €) unitaire',
            ])
            ->add('service', EntityType::class, [
                'label' => 'Service dont l\'option est issue',
                'class' => Service::class,
                'choice_label' => function (Service $service) {
                    return sprintf('%s',$service->getName());
                }
            ]);
    }
}