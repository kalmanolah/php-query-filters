<?php

namespace KalmanOlah\QueryFilter\Filter;

use KalmanOlah\QueryFilter\FilterSet;

/**
 * An interface defining the behaviour of a filter.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
interface FilterInterface
{
    /**
     * Get the identifier for this filter.
     *
     * @return string
     */
    public function getId();

    /**
     * Apply the filter to the given query with the given value
     * on the given field.
     *
     * @param  mixed  &$query Query to filter.
     * @param  string $field  Field to filter on.
     * @param  mixed  $value  Value to filter on.
     * @return void
     */
    public function filter(&$query, string $field, $value);

    /**
     * Set the filter set owning this transformer.
     *
     * @param FilterSet $filterSet Filter set to use.
     * @return TransformerInterface
     */
    public function setFilterSet(FilterSet $filterSet);
}
