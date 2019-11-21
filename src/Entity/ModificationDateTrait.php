<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait ModificationDateTrait
{
    /**
     * @ORM\Column(type="datetime")
     */
    private $modificationDate;

    /**
     * @return object \DateTime
     */
    public function getModificationDate()
    {
        return $this->modificationDate;
    }

    /**
     * @param \DateTime $modificationDate
     */
    public function setModificationDate($modificationDate): void
    {
        $this->modificationDate = $modificationDate;
    }

}