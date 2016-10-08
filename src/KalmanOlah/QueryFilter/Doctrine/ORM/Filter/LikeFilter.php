<?php

namespace KalmanOlah\QueryFilter\Doctrine\ORM\Filter;

/**
 * A filter allowing filtering by checking whether the field
 * contains a value matching the given value partially.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class LikeFilter extends AbstractDoctrineORMFilter
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'like';

    /**
     * {@inheritDoc}
     */
    public function filter(&$query, $field, $value)
    {
        $param = $this->generateParameterName();
        $field = $this->resolveFieldAlias($query, $field);

        $query
            ->andWhere(sprintf('%s LIKE :%s', $field, $param))
            ->setParameter($param, sprintf('%%%s%%', preg_quote($value, '%')));
    }
}
