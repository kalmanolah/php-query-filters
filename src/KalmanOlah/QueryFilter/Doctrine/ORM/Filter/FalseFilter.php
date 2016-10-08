<?php

namespace KalmanOlah\QueryFilter\Doctrine\ORM\Filter;

/**
 * A filter allowing filtering by checking whether the field
 * contains the boolean value "false".
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class FalseFilter extends AbstractDoctrineORMFilter
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'false';

    /**
     * {@inheritDoc}
     */
    public function filter(&$query, $field, $value)
    {
        $field = $this->resolveFieldAlias($query, $field);
        $query->andWhere(sprintf('%s = FALSE', $field));
    }
}
