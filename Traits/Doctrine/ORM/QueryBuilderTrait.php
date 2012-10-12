<?php
namespace Millwright\ConfigurationBundle\Traits\Doctrine\ORM;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

trait QueryBuilderTrait
{
    /**
     * @var EntityRepository
     */
    //protected $repository;

    /**
     * @var string
     */
    protected $alias;

    /**
     * Get query builder for select
     *
     * @return QueryBuilder
     */
    protected function getSelectBuilder()
    {
        return $this->repository->createQueryBuilder($this->alias);
    }

    /**
     * Get query builder for update
     *
     * @return QueryBuilder
     */
    protected function getUpdateBuilder()
    {
        return ORMUtil::createUpdateQueryBuilder($this->repository, $this->alias);
    }
    /**
     * Get query builder for delete
     *
     * @return QueryBuilder
     */
    protected function getDeleteBuilder()
    {
        return ORMUtil::createDeleteQueryBuilder($this->repository, $this->alias);
    }
}
