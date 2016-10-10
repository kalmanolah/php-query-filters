<?php

namespace KalmanOlah\QueryFilter\MongoDB\Filter;

use KalmanOlah\QueryFilter\Filter\AbstractFilter;

/**
 * A filter allowing filtering by checking whether the field
 * contains a value less than to the given value.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class LessThanFilter extends AbstractFilter
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'lt';

    /**
     * {@inheritDoc}
     */
    public function filter(&$query, &$filters, $field, $value)
    {
        $query['$and'][] = [
            $field => [
                '$lt' => $value,
            ],
        ];
    }
}
