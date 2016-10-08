<?php

namespace KalmanOlah\QueryFilter;

use KalmanOlah\QueryFilter\Exception\InvalidFilterException;
use KalmanOlah\QueryFilter\Transformer\TransformerInterface;
use KalmanOlah\QueryFilter\Filter\FilterInterface;


/**
 * A filter set.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class FilterSet
{
    /**
     * @var array<string,FilterInterface>
     */
    protected $filters = [];

    /**
     * @var array<string,TransformerInterface>
     */
    protected $transformers = [];

    /**
     * Constructor.
     */
    public function __construct()
    {
        // Do stuff
    }

    /**
     * Attempt to parse the given filter strings, applying them to the
     * provided query.
     *
     * @param  mixed          &$query         Query to filter.
     * @param  array<string>  $filters        Filters to process, in raw string format.
     * @return void
     */
    public function applyQueryFilters(&$query, array $filters)
    {
        $parsedFilters = $this->parseFilters($filters);

        foreach ($parsedFilters as $parsedFilter) {
            $filter = $this->getFilterById($parsedFilter['filter']);
            $field = $parsedFilter['field'];
            $value = $parsedFilter['value'];

            // If required, transform the value
            if (isset($parsedFilter['transformer'])) {
                $transformer = $this->getTransformerById($parsedFilter['transformer']);
                $value = $transformer->transform($value);
            }

            $filter->filter($query, $field, $value);
        }
    }

    /**
     * Register a filter.
     *
     * @param  FilterInterface $filter Filter to register.
     * @return FilterSet
     */
    public function registerFilter(FilterInterface $filter)
    {
        $this->filters[$filter->getId()] = $filter;
        $filter->setFilterSet($this);

        return $this;
    }

    /**
     * Register a transformer.
     *
     * @param  TransformerInterface $transformer Transformer to register.
     * @return FilterSet
     */
    public function registerTransformer(TransformerInterface $transformer)
    {
        $this->transformers[$transformer->getId()] = $transformer;
        $transformer->setFilterSet($this);

        return $this;
    }

    /**
     * Attempt to parse the given array of filter strings, splitting the
     * strings into fields, values, filter identifiers and optional
     * transformers.
     *
     * @param  array  $filters Filter strings to parse.
     * @return array<array<string,mixed>>
     */
    protected function parseFilters(array $filters)
    {
        return array_map(function ($v) {
            return $this->parseFilter($v);
        }, $filters);
    }

    /**
     * Attempt to parse the given filter string, splitting the string into
     * a field, a value, a filter identifier and optional transformers.
     *
     * @param  string $filter Filter string to parse.
     * @return array<string,mixed>
     */
    protected function parseFilter(string $filter)
    {
        // Split the filter string into field and filterId parts
        list($field, $filterId) = explode(',', $filter, 2);

        // Attempt to extract a value from our filterId string
        $value = null;
        if (strrpos($filterId, ' ') !== false) {
            list($filterId, $value) = explode(' ', $filterId, 2);
        }

        // Attempt to extract a transformerId from our filterId string
        $transformerId = null;
        if (strrpos($filterId, ':') !== false) {
            list($filterId, $transformerId) = explode(':', $filterId, 2);
        }

        return [
            'filter'      => $filterId,
            'value'       => $value,
            'transformer' => $transformerId,
            'field'       => $field,
        ];
    }

    /**
     * Get a filter by ID.
     *
     * @param  string $id ID of filter to get.
     * @return FilterInterface
     */
    protected function getFilterById(string $id)
    {
        if (!isset($this->filters[$id])) {
            throw new InvalidFilterException(sprintf('The filter with ID "%s" coult not be found', $id));
        }

        return $this->filters[$id];
    }

    /**
     * Get a transformer by ID.
     *
     * @param  string $id ID of transformer to get.
     * @return TransformerInterface
     */
    protected function getTransformerById(string $id)
    {
        if (!isset($this->transformers[$id])) {
            throw new InvalidFilterException(sprintf('The transformer with ID "%s" coult not be found', $id));
        }

        return $this->transformers[$id];
    }
}
