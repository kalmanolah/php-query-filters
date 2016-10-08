<?php

namespace KalmanOlah\QueryFilter\MongoDB\Filter;

use KalmanOlah\QueryFilter\Filter\AbstractFilter;

/**
 * A filter allowing filtering by checking whether the field
 * contains a null value.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class NullFilter extends AbstractFilter
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'null';

    /**
     * {@inheritDoc}
     */
    public function filter(&$query, string $field, $value)
    {
        $query['$and'][] = [
            $field => [
                '$eq' => null,
            ],
        ];
    }
}
