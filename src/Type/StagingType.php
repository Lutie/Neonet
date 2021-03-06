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
                'label' => 'Nom de l\'hotel (*)',
            ])
            ->add('nasId', TextType::class, [
                'label' => 'NASID (*)',
            ])
            ->add('license_nasId', ChoiceType::class, [
                'label' => 'Licenses commandées ? (*) Ordering tools',
                'empty_data' => false,
                'choices'  => [
                    'Non' => false,
                    'Oui' => true,
                ],
            ])
            ->add('contact_name', TextType::class, [
                'label' => 'Nom du contact',
            ])
            ->add('contact_phone', TextType::class, [
                'label' => 'Numéro de téléphone',
            ])
            ->add('contact_address', TextType::class, [
                'label' => 'Adresse',
            ])
            ->add('contact_zipcode', TextType::class, [
                'label' => 'Code postal',
            ])
            ->add('contact_city', TextType::class, [
                'label' => 'Ville',
            ])
            ->add('delivery_date', DateType::class, [
                'label' => 'Date de livraison souhaitée',
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y') + 2),
            ])
            ->add('hoist_standard', ChoiceType::class, [
                'label' => 'Standard Hoist',
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])
            ->add('standard_file_upload', FileType::class, [
                'label' => 'Fournir les standards à appliquer',
            ])
            ->add('staging_type', ChoiceType::class, [
                'label' => 'Type de staging (*)',
                'empty_data' => null,
                'multiple' => true,
                'choices'  => [
                    'TV' => 1,
                    'Wifi' => 2,
                    'Chromecast' => 3,
                    'Lan' => 4,
                    'Switch' => 5,
                    'Radio' => 6,
                ],
            ])
            ->add('streamer', ChoiceType::class, [
                'label' => 'Streamer (Anevia...)',
                'empty_data' => false,
                'choices'  => [
                    'Non' => false,
                    'Oui' => true,
                ],
            ])
            ->add('vod', ChoiceType::class, [
                'label' => 'VOD',
                'empty_data' => false,
                'choices'  => [
                    'Non' => false,
                    'Oui' => true,
                ],
            ])
            ->add('tv_channel_plan', TextareaType::class, [
                'label' => 'Plan des chaines TV',
            ])
            ->add('room_list', TextareaType::class, [
                'label' => 'Liste des chambres (101,102,...)',
            ])
            ->add('tv_brand', ChoiceType::class, [
                'label' => 'Marque(s) des TVs',
                'multiple' => true,
                'choices'  => [
                    'LG' => 'LG',
                    'Samsung' => 'Samsung',
                    'Philips' => 'Philips',
                    'stb_LG' => 'stb_LG'
                ],
            ])
            ->add('gui_type', ChoiceType::class, [
                'label' => 'Type de gui',
                'choices'  => [
                    'Resonance' => 'Resonance',
                    'Harmonic' => 'Harmonic',
                    'autre' => 'autre',
                ],
            ])
            ->add('head_brand', ChoiceType::class, [
                'label' => 'Type de bornes',
                'choices'  => [
                    'ruckus' => 'Ruckus',
                    'alcatel' => 'Alcatel',
                    'aruba' => 'Aruba',
                ],
            ])
            ->add('controller_brand', ChoiceType::class, [
                'label' => 'Contrôleur de bornes',
                'choices'  => [
                    'aucun' => 'aucun',
                    'zonedirector' => 'ZoneDirector',
                    'smartzone' => 'SmartZone',
                    'virtualsmartzone' => 'Virtual SmartZone',
                    'autre' => 'autre',
                ],
            ])
            ->add('radio_channel_plan', TextareaType::class, [
                'label' => 'Plan des chaines Radios',
            ])
            ->add('tv_on_wifi', ChoiceType::class, [
                'label' => 'TV branchée à la borne WIFI',
                'empty_data' => false,
                'choices'  => [
                    'Non' => false,
                    'Oui' => true,
                ],
            ])
            ->add('ssid_wifi', TextType::class, [
                'label' => 'Guest SSID',
            ])
            ->add('vlan_wifi', TextType::class, [
                'label' => 'VLAN wifi guest',
            ])
            ->add('guest_ip', TextType::class, [
                'label' => 'Address ip wifi guest',
            ])
            ->add('ssid_vlan', TextType::class, [
                'label' => 'VLAN SSID Chromecast',
            ])
            ->add('lan_file_upload', FileType::class, [
                'label' => 'Pièce jointe',
            ])
            ->add('switch_quantity', IntegerType::class, [
                'label' => 'Quantité de switch',
            ])
            ->add('trader', ChoiceType::class, [
                'label' => 'Type de switch',
                'choices'  => [
                    'Hp'  => 'Hp',
                    'Cisco'  => 'Cisco',
                    'Alcatel'  => 'Alcatel',
                    'Ruckus (Brocade)'  => 'Ruckus (Brocade)',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Informations complémentaires',
            ]);
    }
}