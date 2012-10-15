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
    public static function createUpdateQueryBuilder(EntityRepository $repository, $alias = null)
    {
        if (!$alias) {
            $alias = self::getAlias($repository);
        }

        $qb = $repository->createQueryBuilder($alias);

        return $qb->update($className, $alias);
    }

    /**
     * Create select query builder
     *
     * @param EntityRepository $repository
     * @param null|string      $alias
     *
     * @return QueryBuilder
     */
    public static function createSelectQueryBuilder(EntityRepository $repository, $alias = null)
    {
        if (!$alias) {
            $alias = self::getAlias($repository);
        }

        return $repository->createQueryBuilder($alias);
    }

    /**
     * Get alias by repository
     *
     * @param EntityRepository $repository
     *
     * @return string
     */
    public static function getAlias(EntityRepository $repository)
    {
        $className = $repository->getClassName();

        return strtolower($className);
    }

    public static function createDeleteQueryBuilder(EntityRepository $repository, $alias = null)
    {
        if (!$alias) {
            $alias = self::getAlias($repository);
        }

        $qb = $repository->createQueryBuilder($alias);

        return $qb->delete($className, $alias);
    }

}
