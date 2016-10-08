<?php

namespace KalmanOlah\QueryFilter\MongoDB\Filter;

use KalmanOlah\QueryFilter\Filter\AbstractFilter;

/**
 * A filter allowing filtering by checking whether the field
 * contains a value greater than the given value.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class GreaterThanFilter extends AbstractFilter
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
        $query['$and'][] = [
            $field => [
                '$gt' => $value,
            ],
        ];
    }
}
