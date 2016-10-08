<?php

namespace KalmanOlah\QueryFilter\Doctrine\ORM\Filter;

/**
 * A filter allowing filtering by checking whether the field
 * contains a value greater than the given value.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class GreaterThanFilter extends AbstractDoctrineORMFilter
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'gt';

    /**
     * {@inheritDoc}
     */
    public function filter(&$query, $field, $value)
    {
        $param = $this->generateParameterName();
        $field = $this->resolveFieldAlias($query, $field);

        $query
            ->andWhere(sprintf('%s > :%s', $field, $param))
            ->setParameter($param, $value);
    }
}
