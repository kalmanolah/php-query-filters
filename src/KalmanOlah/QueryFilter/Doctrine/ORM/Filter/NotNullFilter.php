<?php

namespace KalmanOlah\QueryFilter\Doctrine\ORM\Filter;

/**
 * A filter allowing filtering by checking whether the field
 * contains a non-null value.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class NotNullFilter extends AbstractDoctrineORMFilter
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'not_null';

    /**
     * {@inheritDoc}
     */
    public function filter(&$query, $field, $value)
    {
        $field = $this->resolveFieldAlias($query, $field);
        $query->andWhere(sprintf('%s IS NOT NULL', $field));
    }
}
