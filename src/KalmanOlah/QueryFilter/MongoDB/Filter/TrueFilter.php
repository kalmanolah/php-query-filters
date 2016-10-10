<?php

namespace KalmanOlah\QueryFilter\MongoDB\Filter;

use KalmanOlah\QueryFilter\Filter\AbstractFilter;

/**
 * A filter allowing filtering by checking whether the field
 * contains the boolean value "true".
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class TrueFilter extends AbstractFilter
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'true';

    /**
     * {@inheritDoc}
     */
    public function filter(&$query, &$filters, $field, $value)
    {
        $query['$and'][] = [
            $field => [
                '$eq' => true,
            ],
        ];
    }
}
