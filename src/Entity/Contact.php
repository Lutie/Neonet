<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{

    /**
     * @Assert\NotNull()
     * @Assert\Email(checkHost=true)
     * @Assert\Type("string")
     * @Assert\Length(min=7, max=50)
     */
    private $email;

    /**
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Assert\Length(min= 15, max= 255)
     */
    private $message;

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
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

}