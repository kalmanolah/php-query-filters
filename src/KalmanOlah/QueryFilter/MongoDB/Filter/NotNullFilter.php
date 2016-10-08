<?php

namespace KalmanOlah\QueryFilter\MongoDB\Filter;

use KalmanOlah\QueryFilter\Filter\AbstractFilter;

/**
 * A filter allowing filtering by checking whether the field
 * contains a non-null value.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class NotNullFilter extends AbstractFilter
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
        $query['$and'][] = [
            $field => [
                '$ne'     => null,
                '$exists' => true,
            ],
        ];
    }
}
