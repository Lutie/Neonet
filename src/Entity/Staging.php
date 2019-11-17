<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="nnc_staging")
 * @ORM\Entity(repositoryClass="App\Repository\StagingRepository")
 */
class Staging
{

    use IdTrait;

    use DateTrait;

    use NameTrait;

    use UserTrait;

    use DescriptionTrait;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $nasId;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $contact_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\Length(max=20)
     */
    private $contact_phone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $contact_address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\Length(max=20)
     */
    private $contact_zipcode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $contact_city;

    /**
     * @ORM\Column( type="datetime" )
     * @Assert\NotNull()
     * @Assert\Date()
     */
    private $delivery_date;

    /**
     * @ORM\Column( type="boolean" )
     * TODO : sur le formulaire si false alors "fournir standard à utiliser"
     */
    private $hoist_standard = false;

    /**
     * @ORM\Column(type="array")
     * TODO V2 : associer des entities à la place
     */
    private $staging_type = [];

    /**
     * si $staging_type contains TV
     * @ORM\Column( type="boolean" )
     */
    private $streamer;

    /**
     * si $staging_type contains TV
     * @ORM\Column( type="boolean" )
     */
    private $vod;

    /**
     * si $staging_type contains TV
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $tv_channel_plan;

    /**
     * si $staging_type contains TV
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $radio_channel_plan;

    /**
     * si $staging_type contains TV
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $room_list;

    /**
     * si $staging_type contains TV
     * array : LG, Samsung, Philips, stb_LG
     * @ORM\Column( type="array" )
     * TODO V2 : associer des entities à la place
     */
    private $staging_brand = [];

    /**
     * si $staging_type contains TV
     * @ORM\Column( type="array" )
     * TODO V2 : associer des entities à la place
     */
    private $gui_type = [];

    /**
     * @return mixed
     */
    public function getNasId()
    {
        return $this->nasId;
    }

    /**
     * @param mixed $nasId
     */
    public function setNasId($nasId): void
    {
        $this->nasId = $nasId;
    }

    /**
     * @return mixed
     */
    public function getContactName()
    {
        return $this->contact_name;
    }

    /**
     * @param mixed $contact_name
     */
    public function setContactName($contact_name): void
    {
        $this->contact_name = $contact_name;
    }

    /**
     * @return mixed
     */
    public function getContactPhone()
    {
        return $this->contact_phone;
    }

    /**
     * @param mixed $contact_phone
     */
    public function setContactPhone($contact_phone): void
    {
        $this->contact_phone = $contact_phone;
    }

    /**
     * @return mixed
     */
    public function getContactAddress()
    {
        return $this->contact_address;
    }

    /**
     * @param mixed $contact_address
     */
    public function setContactAddress($contact_address): void
    {
        $this->contact_address = $contact_address;
    }

    /**
     * @return mixed
     */
    public function getContactZipcode()
    {
        return $this->contact_zipcode;
    }

    /**
     * @param mixed $contact_zipcode
     */
    public function setContactZipcode($contact_zipcode): void
    {
        $this->contact_zipcode = $contact_zipcode;
    }

    /**
     * @return mixed
     */
    public function getContactCity()
    {
        return $this->contact_city;
    }

    /**
     * @param mixed $contact_city
     */
    public function setContactCity($contact_city): void
    {
        $this->contact_city = $contact_city;
    }

    /**
     * @return mixed
     */
    public function getDeliveryDate()
    {
        return $this->delivery_date;
    }

    /**
     * @param mixed $delivery_date
     */
    public function setDeliveryDate($delivery_date): void
    {
        $this->delivery_date = $delivery_date;
    }

    /**
     * @return mixed
     */
    public function getHoistStandard()
    {
        return $this->hoist_standard;
    }

    /**
     * @param mixed $hoist_standard
     */
    public function setHoistStandard($hoist_standard): void
    {
        $this->hoist_standard = $hoist_standard;
    }

    /**
     * @return mixed
     */
    public function getStagingType()
    {
        return $this->staging_type;
    }

    /**
     * @param mixed $staging_type
     */
    public function setStagingType($staging_type): void
    {
        $this->staging_type = $staging_type;
    }

    /**
     * @return mixed
     */
    public function getStreamer()
    {
        return $this->streamer;
    }

    /**
     * @param mixed $streamer
     */
    public function setStreamer($streamer): void
    {
        $this->streamer = $streamer;
    }

    /**
     * @return mixed
     */
    public function getVod()
    {
        return $this->vod;
    }

    /**
     * @param mixed $vod
     */
    public function setVod($vod): void
    {
        $this->vod = $vod;
    }

    /**
     * @return mixed
     */
    public function getTvChannelPlan()
    {
        return $this->tv_channel_plan;
    }

    /**
     * @param mixed $tv_channel_plan
     */
    public function setTvChannelPlan($tv_channel_plan): void
    {
        $this->tv_channel_plan = $tv_channel_plan;
    }

    /**
     * @return mixed
     */
    public function getRadioChannelPlan()
    {
        return $this->radio_channel_plan;
    }

    /**
     * @param mixed $radio_channel_plan
     */
    public function setRadioChannelPlan($radio_channel_plan): void
    {
        $this->radio_channel_plan = $radio_channel_plan;
    }

    /**
     * @return mixed
     */
    public function getRoomList()
    {
        return $this->room_list;
    }

    /**
     * @param mixed $room_list
     */
    public function setRoomList($room_list): void
    {
        $this->room_list = $room_list;
    }

    /**
     * @return mixed
     */
    public function getStagingBrand()
    {
        return $this->staging_brand;
    }

    /**
     * @param mixed $staging_brand
     */
    public function setStagingBrand($staging_brand): void
    {
        $this->staging_brand = $staging_brand;
    }

    /**
     * @return mixed
     */
    public function getGuiType()
    {
        return $this->gui_type;
    }

    /**
     * @param mixed $gui_type
     */
    public function setGuiType($gui_type): void
    {
        $this->gui_type = $gui_type;
    }

    /**
     * @return object \DateTime
     */
    public function getDate()
    {
        return $this->delivery_date;
    }

    /**
     * @param \DateTime $delivery_date
     */
    public function setDate($delivery_date): void
    {
        $this->delivery_date = $delivery_date;
    }

    // Si Wifi
    // "n'oubliez pas de créer la rate card"

    // liste de ssid avec nom / zone
    // la liste doit s'étendre à mesure qu'il ajoute des éléments
    /**
     * @ORM\Column(type="array")
     */
    private $ssid_list;

    /**
     * si $staging_type contains Wifi
     * array : ruckus, alcatel, aruba
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     * TODO V2 : associer des entities à la place
     */
    private $head_brand = [];

    // type de zone contrôleur
    // un peu comme le type de tv mais un seul choix (parmis une liste dans une table)
    /**
     * si $staging_type contains TV
     * @ORM\Column(type="array")
     */
    private $controller_brand = [];

    // si Wifi ET TV
    // checkbox true/false
    // TV branchée sur borne Wifi
    /**
     * @ORM\Column(type="boolean")
     */
    private $tv_on_wifi;

    // Si Chromcast ET pas de Wifi
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $ssid_wifi;

    // Si Chromcast ET pas de Wifi (?)
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $vlan_wifi;

    // Si Chromcast ET pas de Wifi (?)
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $guest_ip;

    // Si Chromcast ET pas de Wifi (?)
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $ssid_vlan;

    // Si LAN
    // "fournir tous les services, plan d'addressage, VLAN, DHCP, qui doivent être configurés"

    // Si LAN
    // joindre un fichier (xls)
    /**
     * @ORM\Column(type="string")
     */
    private $lan_filename;

    // Si switch
    /**
     * @ORM\Column(type="integer")
     * @Assert\Type("integer")
     */
    private $switch_quantity;

    // Si switch
    // type de zone trader_cdlgapsidesidewhitech
    // un peu comme le type de tv mais un seul choix (parmis une liste dans une table)
    // hp, sisco, alcatel, brocad
    /**
     * @ORM\Column(type="array")
     */
    private $trader;

}
