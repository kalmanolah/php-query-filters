<?php

namespace KalmanOlah\QueryFilter\Doctrine\ORM\Filter;

/**
 * A filter allowing filtering by checking whether the field
 * contains a value less than to the given value.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class LessThanFilter extends AbstractDoctrineORMFilter
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'lt';

    /**
     * {@inheritDoc}
     */
    public function filter(&$query, $field, $value)
    {
        $param = $this->generateParameterName();
        $field = $this->resolveFieldAlias($query, $field);

        $query
            ->andWhere(sprintf('%s < :%s', $field, $param))
            ->setParameter($param, $value);
    }
}
