<?php

namespace App\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class StagingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du service',
            ])
            ->add('nasId', IntegerType::class, [
                'label' => 'Id du NAS',
            ])
            ->add('contact_name', TextType::class, [
                'label' => 'Nom du contact',
            ])
            ->add('contact_name', TextType::class, [
                'label' => 'Numéro de téléphone du contact',
            ])
            ->add('contact_address', TextType::class, [
                'label' => 'Addresse du contact',
            ])
            ->add('contact_zipcode', TextType::class, [
                'label' => 'Numéro de zipcode du contact',
            ])
            ->add('contact_city', TextType::class, [
                'label' => 'Ville du contact',
            ])
            ->add('delivery_date', DateType::class, [
                'label' => 'Date de livraison',
            ])
            ->add('hoist_standard', ChoiceType::class, [
                'label' => 'Standard Hoist',
                'empty_data' => false,
                'choices'  => [
                    'Non' => false,
                    'Oui' => true,
                ],
            ])
            ->add('staging_type', ChoiceType::class, [
                'label' => 'Standard Hoist',
                'multiple' => true,
                'choices'  => [
                    'TV' => 1,
                    'Wifi' => 2,
                    'Chromcast' => 3,
                    'Lan' => 4,
                    'switch' => 5,
                ],
            ])
            ->add('streamer', ChoiceType::class, [
                'label' => 'Streamer (ssi TV)',
                'empty_data' => false,
                'choices'  => [
                    'Non' => false,
                    'Oui' => true,
                ],
            ])
            ->add('vod', ChoiceType::class, [
                'label' => 'VOD (ssi TV)',
                'empty_data' => false,
                'choices'  => [
                    'Non' => false,
                    'Oui' => true,
                ],
            ])
            ->add('tv_channel_plan', TextType::class, [
                'label' => 'Plan des chaines TV (ssi TV)',
            ])
            ->add('radio_channel_plan', TextType::class, [
                'label' => 'Plan des chaines Radios (ssi radio)',
            ])
            ->add('room_list', TextType::class, [
                'label' => 'Liste des chambres (ssi TV)',
            ])
            ->add('staging_brand', ChoiceType::class, [
                'label' => 'Marque(s) des TVs (ssi TV)',
                'multiple' => true,
                'choices'  => [
                    'LG',
                    'Samsung',
                    'Philips',
                    'stb_LG'
                ],
            ])
            ->add('staging_type', ChoiceType::class, [
                'label' => 'Standard Hoist (ssi TV)',
                'multiple' => true,
                'choices'  => [
                    'TV' => 1,
                    'Wifi' => 2,
                    'Chromcast' => 3,
                    'Lan' => 4,
                    'switch' => 5,
                ],
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom du service',
            ])
            ->add('head_brand', ChoiceType::class, [
                'label' => 'Type de borne (ssi TV)',
                'choices'  => [
                    'ruckus',
                    'alcatel',
                    'aruba'
                ],
            ])
            ->add('controller_brand', ChoiceType::class, [
                'label' => 'Contrôleur de zone (ssi TV)',
                'choices'  => [
                    'aucun',
                    'zonedirector',
                    'smartzone',
                    'virtualsmartzone',
                    'autre'
                ],
            ])
            ->add('tv_on_wifi', ChoiceType::class, [
                'label' => 'TV branchée à la borne WIFI (ssi wifi et tv)',
                'empty_data' => false,
                'choices'  => [
                    'Non' => false,
                    'Oui' => true,
                ],
            ])
            ->add('ssid_wifi', TextType::class, [
                'label' => 'SSID wifi (ssi Chromcast ET pas de Wifi)',
            ])
            ->add('vlan_wifi', TextType::class, [
                'label' => 'VLAN wifi guest (ssi Chromcast ET pas de Wifi)',
            ])
            ->add('guest_ip', TextType::class, [
                'label' => ' Address ip wifi guest (ssi Chromcast ET pas de Wifi)',
            ])
            ->add('ssid_vlan', TextType::class, [
                'label' => 'VLAN SSID Chromcast (ssi Chromcast ET pas de Wifi)',
            ])
            ->add('lan_file', FileType::class, [
                'label' => 'Fournir tous les services, plan d\'addressage, VLAN, DHCP, qui doivent être configurés',
            ])
            ->add('switch_quantity', IntegerType::class, [
                'label' => 'Quantité de switch (ssi switch)',
            ])
            ->add('trader', ChoiceType::class, [
                'label' => 'type de zone trader (ssi switch)',
                'choices'  => [
                    'hp', 'sisco', 'alcatel', 'brocad'
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Informations complémentaires',
            ]);
    }
}