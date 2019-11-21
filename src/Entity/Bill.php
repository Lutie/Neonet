<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="nnc_bill")
 * @ORM\Entity(repositoryClass="App\Repository\BillRepository")
 */
class Bill
{

    use IdTrait;

    use DateTrait;

    use NameTrait;

    use ModificationDateTrait;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="bills")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\Column(type="integer", length=10)
     * @Assert\Type("integer")
     */
    private $price;

    /**
     * @ORM\Column(type="array")
     */
    private $services = [];

    /**
     * @ORM\Column(type="array")
     */
    private $items = [];

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $description;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->modificationDate = new \DateTime();
        $this->price = 0;
    }

    /**
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param integer $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return array
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @param integer $service
     */
    public function addService($service): void
    {
        $this->services[] = $service;
    }

    /**
     * @param array $services
     */
    public function setServices($services): void
    {
        $this->services = $services;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param array $item
     * @Doc must me an indexed array containing IDservice "on"
     * Ex : [1, 3, 5, 12]
     */
    public function addItem($item): void
    {
        $this->items[] = $item;
    }

    /**
     * @param array $items
     * @Doc must me a multidimentional array containing IDitem => quantity association
     * Ex : [1 => 3, 3 => 4, 5 => 12]
     */
    public function setItems($items): void
    {
        $this->items = $items;
    }

    /**
     * @return object User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function drop(): void
    {
        $this->services = [];
        $this->items = [];
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

}