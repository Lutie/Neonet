<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="nnc_user")
 * @UniqueEntity(fields={"email"})
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{

    use IdTrait;

    use DateTrait;

    /**
     * @ORM\Column(type="string", unique=true, length=100, nullable=false)
     * @Assert\NotNull()
     * @Assert\Email(checkHost=false)
     * @Assert\Type("string")
     * @Assert\Length(max=100)
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="Bill", mappedBy="user")
     * @ORM\JoinColumn(nullable=true)
     */
    private $bills;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    private $isAdmin = 0;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->roles = ["ROLE_USER"];
        $this->bills = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

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

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles): void
    {
        $this->roles = [$roles];
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        $this->rawPassword = null;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     */
    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

}