<?php

namespace Portfolio\CoreBundle\Repository;

/**
 * ContactRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContactRepository extends \Doctrine\ORM\EntityRepository
{
	public function findEntities()
    {
        return $this->createQueryBuilder('e')
                ->orderBy('e.id', 'DESC')
                ->getQuery()
                ->getResult();
    }
}
