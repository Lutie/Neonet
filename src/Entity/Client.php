<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="nnc_client")
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{

    use IdTrait;

    use NameTrait;

    use DescriptionTrait;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $street;

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $city;

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @ORM\OneToMany(targetEntity="Bill", mappedBy="client")
     * @ORM\JoinColumn(nullable=true)
     */
    private $bills;

    /**
     * @return object Bill
     */
    public function getBills()
    {
        return $this->bills;
    }

    /**
     * @param Bill $bills
     */
    public function setBills($bills): void
    {
        $this->bills = $bills;
    }

}