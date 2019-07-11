<?php

namespace App\CoreBundle\Repository;

use App\CoreBundle\Entity\Newsletter;

/**
 * NewsletterRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NewsletterRepository extends \Doctrine\ORM\EntityRepository
{
    public function create() {
        return new Newsletter;
    }

    public function findEntities($key = null)
    {
        $query = $this->createQueryBuilder('e')
                ->select('e')
                ->orderBy('e.id', 'DESC');
                if(null !== $key){
                    $query->where('e.email LIKE :key')
                        ->setParameter('key', '%'.$key.'%');
                }

        return $query->getQuery()->getResult();
    }   
	public function findLatestUncheckeds($limit)
    {
        return $this->createQueryBuilder('e')
                ->select('e')
                ->where('e.checked = :checked')
                ->setParameter('checked', 0) 
                ->orderBy('e.id', 'DESC')
            	->setMaxResults($limit)
            	->getQuery()
            	->getResult();
    }

    public function findFilter($filter)
    {
        return $this->createQueryBuilder('e')
                ->select('e')
                ->where('e.'.$filter.' = :filter')
                ->setParameter('filter', 0) 
                ->orderBy('e.id', 'DESC')
                ->getQuery()
                ->getResult();
    }

    public function countUnchecked()
    {
        return $this
            ->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->where('e.checked = :checked')
            ->setParameter('checked', 0)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countAll()
    {
        return $this
            ->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
    
    public function filterAll($filter)
    {
        return $this->createQueryBuilder('e')
                    ->update()
                    ->set('e.'.$filter, 1)
                    ->where('e.'.$filter.' = :filter')
                    ->setParameter('filter', false)
                    ->getQuery()
                    ->getResult();
    }

    public function deleteAll($filter)
    {
        return $this->createQueryBuilder('e')
                    ->where('e.'.$filter.' = :filter')
                    ->setParameter('filter', false)
                    ->delete()
                    ->getQuery()
                    ->execute();
    }
}
