<?php

namespace KalmanOlah\QueryFilter\Transformer;

use KalmanOlah\QueryFilter\FilterSet;

/**
 * An interface defining the behaviour of a data transformer.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
interface TransformerInterface
{
    /**
     * Get the identifier for this transformer.
     *
     * @return string
     */
    public function getId();

    /**
     * Transform a string value.
     *
     * @param  string $value Value fo transform.
     * @return mixed
     */
    public function transform($value);

    /**
     * Set the filter set owning this transformer.
     *
     * @param FilterSet $filterSet Filter set to use.
     * @return TransformerInterface
     */
    public function setFilterSet(FilterSet $filterSet);
}
