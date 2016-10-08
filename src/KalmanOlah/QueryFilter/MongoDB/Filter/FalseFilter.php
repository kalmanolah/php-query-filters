<?php

namespace KalmanOlah\QueryFilter\MongoDB\Filter;

use KalmanOlah\QueryFilter\Filter\AbstractFilter;

/**
 * A filter allowing filtering by checking whether the field
 * contains the boolean value "false".
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class FalseFilter extends AbstractFilter
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
        $query['$and'][] = [
            $field => [
                '$eq' => false,
            ],
        ];
    }
}
