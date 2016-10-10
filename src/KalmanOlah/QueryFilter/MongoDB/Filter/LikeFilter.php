<?php

namespace KalmanOlah\QueryFilter\MongoDB\Filter;

use KalmanOlah\QueryFilter\Filter\AbstractFilter;

/**
 * A filter allowing filtering by checking whether the field
 * contains a value matching the given value partially.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class LikeFilter extends AbstractFilter
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'like';

    /**
     * {@inheritDoc}
     */
    public function filter(&$query, &$filters, $field, $value)
    {
        // $value = preg_quote($value, '/');
        $value = new \MongoDB\BSON\Regex($value, 'i');

        $query['$and'][] = [
            $field => [
                '$regex' => $value,
            ],
        ];
    }
}
