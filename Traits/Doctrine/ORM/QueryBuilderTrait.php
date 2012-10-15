<?php
namespace Millwright\ConfigurationBundle\Traits\Doctrine\ORM;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Millwright\ConfigurationBundle\ORM\ORMUtil;

trait QueryBuilderTrait
{
    /**
     * @var EntityRepository
     */
    //protected $repository;

    /**
     * Get query builder for select
     *
     * @return QueryBuilder
     */
    protected function getSelectBuilder($alias = null)
    {
        if (!$alias) {
            $alias = ORMUtil::getAlias($this->repository);
        }

        return $this->repository->createQueryBuilder($alias);
    }

    /**
     * Get query builder for update
     *
     * @return QueryBuilder
     */
    protected function getUpdateBuilder($alias = null)
    {
        return ORMUtil::createUpdateQueryBuilder($this->repository, $alias);
    }
    /**
     * Get query builder for delete
     *
     * @return QueryBuilder
     */
    protected function getDeleteBuilder($alias = null)
    {
        return ORMUtil::createDeleteQueryBuilder($this->repository, $alias);
    }
}
