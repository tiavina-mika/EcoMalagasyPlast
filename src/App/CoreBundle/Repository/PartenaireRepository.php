<?php

namespace App\CoreBundle\Repository;

use App\CoreBundle\Entity\Partenaire;

/**
 * PartenaireRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PartenaireRepository extends \Doctrine\ORM\EntityRepository
{
    public function create() {
        return new Partenaire;
    }

    public function findEntities($key = null)
    {
        $query = $this->createQueryBuilder('e')
                ->select('e', 'u')
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
                ->select('e','e_i','logo')
                ->leftJoin('e.partenaireLogo', 'logo')
                ->leftJoin('e.partenaireImage', 'e_i')
                ->where('e.slug = :slug')
                ->setParameters(['slug' => $slug])           
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

    public function findLatest($limit)
    {
        return $this->createQueryBuilder('e')
                ->select('e','i', 'l')
                ->leftJoin('e.partenaireImage', 'i')
                ->leftJoin('e.partenaireLogo', 'l')
                ->orderBy('e.id', 'DESC')
                ->setMaxResults($limit)
                ->getQuery()->getResult();
    }

    public function findList($limit)
    {
        return $this->createQueryBuilder('e')
                ->select('e')
                ->orderBy('e.id', 'DESC')
                ->setMaxResults($limit)
                ->getQuery()->getResult();
    }

    public function findEnabledEntities()
    {
        return $this->createQueryBuilder('e')
                ->select('e','i')
                ->leftJoin('e.partenaireImage', 'i')
                ->orderBy('e.id', 'DESC')
                ->where('e.enabled = :enabled')
                ->setParameter('enabled', 1)
                ->getQuery()->getResult();
    }
    public function countAll()
    {
        return $this
            ->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
