<?php

namespace KalmanOlah\QueryFilter\MongoDB\Filter;

use KalmanOlah\QueryFilter\Filter\AbstractFilter;

/**
 * A filter allowing filtering by multiple filters,
 * one of which must match.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class OrFilter extends AbstractFilter
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'or';

    /**
     * {@inheritDoc}
     */
    public function filter(&$query, &$filters, $field, $value)
    {
        // Parse indexes of filters to wrap in OR
        $indexes = array_map('intval', explode(',', $value));

        // Remove selected filters from parent filter array,
        // meaning they won't be processed by the filter set
        // separately
        $orFilters = array_map(function ($index) use (&$filters) {
            $value = $filters[$index];
            $filters[$index] = null;

            return $value;
        }, $indexes);

        $orQuery = [
            '$and' => [],
        ];

        $this->filterSet->applyParsedFilters($orQuery, $orFilters);

        $query['$and'][] = [
            '$or' => $orQuery['$and'],
        ];
    }
}
