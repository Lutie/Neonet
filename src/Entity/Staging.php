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

    use ModificationDateTrait;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="NASID nécessaire !")
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $nasId;

    /**
     * @ORM\Column( type="boolean" )
     * @Assert\IsTrue(message="License nécessaire !")
     */
    private $license_nasId = false;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $contact_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length(max=20)
     */
    private $contact_phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $contact_address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length(max=20)
     */
    private $contact_zipcode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $contact_city;

    /**
     * @ORM\Column( type="datetime", nullable=true)
     * @Assert\Date()
     */
    private $delivery_date;

    /**
     * @ORM\Column( type="boolean" )
     */
    private $hoist_standard = true;

    /**
     * @Assert\File(
     *     maxSize = "3k",
     *     mimeTypes = {"application/pdf",
     *          "text/plain",
     *          "application/msword",
     *          "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
     *          "application/vnd.openxmlformats-officedocument.presentationml.presentation",
     *          "application/vnd.ms-excel",
     *          "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"},
     *     mimeTypesMessage = "Veuillez déposer un fichier (txt, doc, xls, etc...) valide (3mo maximum)"
     * )
     */
    private $standard_file_upload;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $standard_file_path;

    /**
     * @ORM\Column(type="array")
     * @Assert\NotNull()
     */
    private $staging_type = [];

    /**
     * @ORM\Column( type="boolean", nullable=true )
     */
    private $streamer;

    /**
     * @ORM\Column( type="boolean", nullable=true )
     */
    private $vod;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $tv_channel_plan;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $radio_channel_plan;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $room_list;

    /**
     * @ORM\Column( type="array", nullable=true )
     */
    private $tv_brand = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $gui_type;

    // liste de ssid avec nom / zone
    // la liste doit s'étendre à mesure qu'il ajoute des éléments
    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $ssid_list;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $head_brand;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $controller_brand;

    /**
     * @ORM\Column(type="boolean")
     */
    private $tv_on_wifi = false;

    // Si Chromcast ET pas de Wifi
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $ssid_wifi;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $vlan_wifi;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $guest_ip;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $ssid_vlan;

    /**
     * @Assert\File(
     *     maxSize = "3k",
     *     mimeTypes = {"application/pdf",
     *          "text/plain",
     *          "application/msword",
     *          "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
     *          "application/vnd.openxmlformats-officedocument.presentationml.presentation",
     *          "application/vnd.ms-excel",
     *          "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"},
     *     mimeTypesMessage = "Veuillez déposer un fichier (txt, doc, xls, etc...) valide (3mo maximum)"
     * )
     */
    private $lan_file_upload;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lan_file_path;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $lan_file_name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type("integer")
     */
    private $switch_quantity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $trader;

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
    public function getTvBrand()
    {
        return $this->tv_brand;
    }

    /**
     * @param mixed $tv_brand
     */
    public function setTvBrand($tv_brand): void
    {
        $this->tv_brand = $tv_brand;
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

    /**
     * @return mixed
     */
    public function getSsidList()
    {
        return $this->ssid_list;
    }

    /**
     * @param mixed $ssid_list
     */
    public function setSsidList($ssid_list): void
    {
        $this->ssid_list = $ssid_list;
    }

    /**
     * @return mixed
     */
    public function getHeadBrand()
    {
        return $this->head_brand;
    }

    /**
     * @param mixed $head_brand
     */
    public function setHeadBrand($head_brand): void
    {
        $this->head_brand = $head_brand;
    }

    /**
     * @return mixed
     */
    public function getControllerBrand()
    {
        return $this->controller_brand;
    }

    /**
     * @param mixed $controller_brand
     */
    public function setControllerBrand($controller_brand): void
    {
        $this->controller_brand = $controller_brand;
    }

    /**
     * @return mixed
     */
    public function getTvOnWifi()
    {
        return $this->tv_on_wifi;
    }

    /**
     * @param mixed $tv_on_wifi
     */
    public function setTvOnWifi($tv_on_wifi): void
    {
        $this->tv_on_wifi = $tv_on_wifi;
    }

    /**
     * @return mixed
     */
    public function getSsidWifi()
    {
        return $this->ssid_wifi;
    }

    /**
     * @param mixed $ssid_wifi
     */
    public function setSsidWifi($ssid_wifi): void
    {
        $this->ssid_wifi = $ssid_wifi;
    }

    /**
     * @return mixed
     */
    public function getVlanWifi()
    {
        return $this->vlan_wifi;
    }

    /**
     * @param mixed $vlan_wifi
     */
    public function setVlanWifi($vlan_wifi): void
    {
        $this->vlan_wifi = $vlan_wifi;
    }

    /**
     * @return mixed
     */
    public function getGuestIp()
    {
        return $this->guest_ip;
    }

    /**
     * @param mixed $guest_ip
     */
    public function setGuestIp($guest_ip): void
    {
        $this->guest_ip = $guest_ip;
    }

    /**
     * @return mixed
     */
    public function getSsidVlan()
    {
        return $this->ssid_vlan;
    }

    /**
     * @param mixed $ssid_vlan
     */
    public function setSsidVlan($ssid_vlan): void
    {
        $this->ssid_vlan = $ssid_vlan;
    }

    /**
     * @return mixed
     */
    public function getLanFilename()
    {
        return $this->lan_filename;
    }

    /**
     * @param mixed $lan_filename
     */
    public function setLanFilename($lan_filename): void
    {
        $this->lan_filename = $lan_filename;
    }

    /**
     * @return mixed
     */
    public function getSwitchQuantity()
    {
        return $this->switch_quantity;
    }

    /**
     * @param mixed $switch_quantity
     */
    public function setSwitchQuantity($switch_quantity): void
    {
        $this->switch_quantity = $switch_quantity;
    }

    /**
     * @return mixed
     */
    public function getTrader()
    {
        return $this->trader;
    }

    /**
     * @param mixed $trader
     */
    public function setTrader($trader): void
    {
        $this->trader = $trader;
    }

    /**
     * @return mixed
     */
    public function getLicenseNasId()
    {
        return $this->license_nasId;
    }

    /**
     * @param mixed $license_nasId
     */
    public function setLicenseNasId($license_nasId): void
    {
        $this->license_nasId = $license_nasId;
    }

    /**
     * @return mixed
     */
    public function getLanFileUpload()
    {
        return $this->lan_file_upload;
    }

    /**
     * @param mixed $lan_file_upload
     */
    public function setLanFileUpload($lan_file_upload)
    {
        $this->lan_file_upload = $lan_file_upload;
    }

    /**
     * @return mixed
     */
    public function getStandardFileUpload()
    {
        return $this->standard_file_upload;
    }

    /**
     * @param mixed $standard_file_upload
     */
    public function setStandardFileUpload($standard_file_upload): void
    {
        $this->standard_file_upload = $standard_file_upload;
    }

    /**
     * @return mixed
     */
    public function getLanFilePath()
    {
        return $this->lan_file_path;
    }

    /**
     * @param mixed $lan_file_path
     */
    public function setLanFilePath($lan_file_path): void
    {
        $this->lan_file_path = $lan_file_path;
    }

    /**
     * @return mixed
     */
    public function getStandardFilePath()
    {
        return $this->standard_file_path;
    }

    /**
     * @param mixed $standard_file_path
     */
    public function setStandardFilePath($standard_file_path): void
    {
        $this->standard_file_path = $standard_file_path;
    }

}
