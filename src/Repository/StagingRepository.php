<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class StagingRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy([], ['date' => 'ASC']);
    }
}