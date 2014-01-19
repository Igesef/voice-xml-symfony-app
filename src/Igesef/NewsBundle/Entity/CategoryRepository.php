<?php

namespace Igesef\NewsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

/**
 * Category repository
 *
 * @author Ignacy Sawicki <igesef@gmail.com>
 */
class CategoryRepository extends EntityRepository
{
    /**
     * Returns all category entities where parent category is null
     *
     * @return ArrayCollection|Category[]
     */
    public function findAllMainCategories()
    {
        $qb = $this->createQueryBuilder('category');
        $qb->where($qb->expr()->isNull('category.parent'));

        return $qb->getQuery()->getResult();
    }

    /**
     * Find all categories whose parent is specified category
     *
     * @param Category $category
     *
     * @return ArrayCollection|Category[]
     */
    public function findSubcategoriesByCategory(Category $category)
    {
        $qb = $this->createQueryBuilder('category');
        $qb->where($qb->expr()->eq('category.parent', ':category'));
        $qb->setParameter('category', $category);

        return $qb->getQuery()->getResult();
    }
}
