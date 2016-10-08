<?php

namespace KalmanOlah\QueryFilter\Filter;

use KalmanOlah\QueryFilter\FilterSet;

/**
 * A base implementation of a filter,
 * allowing for easy extension.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
abstract class AbstractFilter implements FilterInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * Apply the filter to the given query with the given value
     * on the given field.
     *
     * @param  mixed  &$query Query to filter.
     * @param  string $field  Field to filter on.
     * @param  mixed  $value  Value to filter on.
     * @return void
     */
    abstract public function filter(&$query, string $field, $value);

    /**
     * @var FilterSet
     */
    protected $filterSet;

    /**
     * Get the identifier for this filter.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the filter set owning this filter.
     *
     * @param FilterSet $filterSet Filter set to use.
     * @return AbstractFilter
     */
    public function setFilterSet(FilterSet $filterSet)
    {
        $this->filterSet = $filterSet;

        return $this;
    }
}
