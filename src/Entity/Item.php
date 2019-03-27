<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="nnc_item")
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 */
class Item
{

    use IdTrait;

    use NameTrait;

    use DescriptionTrait;

    use PriceTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="items")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $service;

    public function getService()
    {
        return $this->service;
    }

    public function setService($service)
    {
        $this->service = $service;
    }

}