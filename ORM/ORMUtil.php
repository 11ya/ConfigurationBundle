<?php
namespace Millwright\ConfigurationBundle\ORM;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;

/**
 * Statuc orm util class
 */
class ORMUtil
{
    /**
     * Get update query builder
     *
     * @param EntityRepository $repository
     * @param string|null      $alias
     *
     * @return QueryBuilder
     */
    static public function createUpdateQueryBuilder(EntityRepository $repository, $alias = null)
    {
        $className = $repository->getClassName();

        if (null === $alias) {
            $alias = lcfirst($className[0]);
        }

        $qb = $repository->createQueryBuilder($alias);

        return $qb->update($className, $alias);
    }

    static public function createDeleteQueryBuilder(EntityRepository $repository, $alias = null)
    {
        $className = $repository->getClassName();

        if (null === $alias) {
            $alias = lcfirst($className[0]);
        }

        $qb = $repository->createQueryBuilder($alias);

        return $qb->delete($className, $alias);
    }

}
