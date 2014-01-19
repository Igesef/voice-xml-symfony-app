<?php

namespace Igesef\NewsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

/**
 * NewsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NewsRepository extends EntityRepository
{
    /**
     * Find all news entries by specified category
     *
     * @param Category $category
     *
     * @return ArrayCollection|News[]
     */
    public function findNewsByCategory(Category $category)
    {
        $qb = $this->createQueryBuilder('news');
        $qb->where($qb->expr()->eq('news.category', ':category'));
        $qb->setParameter('category', $category);

        return $qb->getQuery()->getResult();
    }
}
