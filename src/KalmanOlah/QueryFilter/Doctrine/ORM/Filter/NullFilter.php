<?php

namespace KalmanOlah\QueryFilter\Doctrine\ORM\Filter;

/**
 * A filter allowing filtering by checking whether the field
 * contains a null value.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class NullFilter extends AbstractDoctrineORMFilter
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'null';

    /**
     * {@inheritDoc}
     */
    public function filter(&$query, $field, $value)
    {
        $field = $this->resolveFieldAlias($query, $field);
        $query->andWhere(sprintf('%s IS NULL', $field));
    }
}
