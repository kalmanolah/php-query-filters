<?php

namespace KalmanOlah\QueryFilter\Doctrine\ORM\Filter;

/**
 * A filter allowing filtering by multiple filters,
 * one of which must match.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class OrFilter extends AbstractDoctrineORMFilter
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'or';

    /**
     * {@inheritDoc}
     */
    public function generateStatement(&$query, &$filters, $field, $value)
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

        // Generate statements for all wrapped filters
        $filterSet = $this->filterSet;
        $statements = array_map(function ($orFilter) use (&$query, &$filters, $filterSet) {
            $filter = $filterSet->getFilterById($orFilter['filter']);
            $field = $orFilter['field'];
            $value = $orFilter['value'];

            // If required, transform the value
            if (isset($orFilter['transformer'])) {
                $transformer = $filterSet->getTransformerById($orFilter['transformer']);
                $value = $transformer->transform($value);
            }

            $statement = $filter->generateStatement($query, $filters, $field, $value);

            // Merge all statements before returning
            $statement['query'] = sprintf('(%s)', implode(' AND ', $statement['query']));

            return $statement;
        }, $orFilters);

        // Merge statements
        $statement = [
            'query'      => [implode(' OR ', array_column($statements, 'query'))],
            'parameters' => call_user_func_array('array_merge', array_column($statements, 'parameters')),
        ];

        return $statement;
    }
}
