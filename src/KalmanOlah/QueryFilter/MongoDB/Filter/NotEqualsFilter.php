<?php

namespace KalmanOlah\QueryFilter\MongoDB\Filter;

use KalmanOlah\QueryFilter\Filter\AbstractFilter;

/**
 * A filter allowing filtering by checking whether the field
 * contains a value that doesn't equal the given value.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class NotEqualsFilter extends AbstractFilter
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'ne';

    /**
     * {@inheritDoc}
     */
    public function filter(&$query, &$filters, $field, $value)
    {
        $query['$and'][] = [
            $field => [
                '$ne' => $value,
            ],
        ];
    }
}
