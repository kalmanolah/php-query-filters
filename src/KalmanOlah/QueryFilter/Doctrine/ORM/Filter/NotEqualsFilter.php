<?php

namespace KalmanOlah\QueryFilter\Doctrine\ORM\Filter;

/**
 * A filter allowing filtering by checking whether the field
 * contains a value that doesn't equal the given value.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class NotEqualsFilter extends AbstractDoctrineORMFilter
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'ne';

    /**
     * {@inheritDoc}
     */
    public function filter(&$query, string $field, $value)
    {
        $param = $this->generateParameterName($field);
        $field = $this->resolveFieldAlias($query, $field);

        $query
            ->andWhere(sprintf('%s != :%s', $field, $param))
            ->setParameter($param, $value);
    }
}
