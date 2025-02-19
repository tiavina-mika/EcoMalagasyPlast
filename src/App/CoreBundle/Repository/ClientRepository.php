<?php

namespace App\CoreBundle\Repository;

use App\CoreBundle\Entity\Client;

/**
 * ClientRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClientRepository extends \Doctrine\ORM\EntityRepository
{
	public function create() {
        return new Client;
    }

    public function findEntities($key = null)
    {
        $query = $this->createQueryBuilder('e')
                ->select('e','u')
                ->leftJoin('e.user', 'u')
                ->orderBy('e.id', 'DESC');
                if(null !== $key){
                    $query->where('e.name LIKE :key OR u.username LIKE :key')
                        ->setParameter('key', '%'.$key.'%');
                }

        return $query->getQuery()->getResult();
    }

	public function findEntityBySlug($slug)
    {
        return $this->createQueryBuilder('e')
                ->select('e','c')
                ->leftJoin('e.commandes', 'c')

                ->where('e.slug = :slug')
                ->andWhere('e.enabled = :enabled')
                ->setParameters(['slug' => $slug, 'enabled' => 1])           
                ->getQuery()
                ->getOneOrNullResult();
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

    public function findFilteAll($filter)
    {
        return $this->createQueryBuilder('e')
                ->select('e')
                ->where('e.'.$filter.' = :filter')
                ->setParameter('filter', false) 
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
            ->setParameter('checked', false)
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
                    ->where('e.'.$filter.' = 0')
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
