<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class ServiceRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy([], ['name' => 'ASC']);
    }
}