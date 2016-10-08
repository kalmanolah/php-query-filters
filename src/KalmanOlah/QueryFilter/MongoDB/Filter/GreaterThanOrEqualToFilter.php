<?php

namespace KalmanOlah\QueryFilter\MongoDB\Filter;

use KalmanOlah\QueryFilter\Filter\AbstractFilter;

/**
 * A filter allowing filtering by checking whether the field
 * contains a value greater than or equal to the given value.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class GreaterThanOrEqualToFilter extends AbstractFilter
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'gte';

    /**
     * {@inheritDoc}
     */
    public function filter(&$query, string $field, $value)
    {
        $query['$and'][] = [
            $field => [
                '$gte' => $value,
            ],
        ];
    }
}
