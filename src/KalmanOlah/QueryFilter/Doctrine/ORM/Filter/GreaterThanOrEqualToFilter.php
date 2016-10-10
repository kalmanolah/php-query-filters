<?php

namespace KalmanOlah\QueryFilter\Doctrine\ORM\Filter;

/**
 * A filter allowing filtering by checking whether the field
 * contains a value greater than or equal to the given value.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class GreaterThanOrEqualToFilter extends AbstractDoctrineORMFilter
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'gte';

    /**
     * {@inheritDoc}
     */
    public function filter(&$query, &$filters, $field, $value)
    {
        $param = $this->generateParameterName();
        $field = $this->resolveFieldAlias($query, $field);

        $query
            ->andWhere(sprintf('%s >= :%s', $field, $param))
            ->setParameter($param, $value);
    }
}
