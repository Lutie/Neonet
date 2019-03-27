<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="nnc_service")
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service
{

    use IdTrait;

    use NameTrait;

    use DescriptionTrait;

    use PriceTrait;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type("integer")
     */
    private $dependency;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Service", mappedBy="service")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $services;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="services")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $service;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Item", mappedBy="service")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->services = new ArrayCollection();
    }

    public function getItems()
    {
        return $this->items;
    }

    public function removeItems(Item $item)
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
        }
        return $this;
    }

    public function addItems(Item $item)
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
        }
        return $this;
    }

    public function getServices()
    {
        return $this->services;
    }

    public function removeServices(Item $services)
    {
        if ($this->services->contains($services)) {
            $this->services->removeElement($services);
        }
        return $this;
    }

    public function addServices(Item $services)
    {
        if (!$this->services->contains($services)) {
            $this->services->add($services);
        }
        return $this;
    }

    public function getService()
    {
        return $this->service;
    }

    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * @return integer
     */
    public function getDependency()
    {
        return $this->dependency;
    }

    /**
     * @param integer $dependency
     */
    public function setDependency($dependency): void
    {
        $this->dependency = $dependency;
    }

}