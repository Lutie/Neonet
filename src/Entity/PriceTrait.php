<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait PriceTrait
{
    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\NotNull()
     * @Assert\Type("integer")
     */
    private $price = 0;

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

}