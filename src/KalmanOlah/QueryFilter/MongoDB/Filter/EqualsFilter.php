<?php

namespace KalmanOlah\QueryFilter\MongoDB\Filter;

use KalmanOlah\QueryFilter\Filter\AbstractFilter;

/**
 * A filter allowing filtering by checking whether the field
 * contains a specific value.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class EqualsFilter extends AbstractFilter
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'eq';

    /**
     * {@inheritDoc}
     */
    public function filter(&$query, string $field, $value)
    {
        $query['$and'][] = [
            $field => [
                '$eq' => $value,
            ],
        ];
    }
}
