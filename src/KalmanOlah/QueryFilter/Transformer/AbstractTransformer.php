<?php

namespace KalmanOlah\QueryFilter\Transformer;

use KalmanOlah\QueryFilter\FilterSet;

/**
 * A base implementation of a data transformer,
 * allowing for easy extension.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
abstract class AbstractTransformer implements TransformerInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * Transform a string value.
     *
     * @param  string $value Value fo transform.
     * @return mixed
     */
    abstract public function transform($value);

    /**
     * @var FilterSet
     */
    protected $filterSet;

    /**
     * Get the identifier for this transformer.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the filter set owning this transformer.
     *
     * @param FilterSet $filterSet Filter set to use.
     * @return AbstractTransformer
     */
    public function setFilterSet(FilterSet $filterSet)
    {
        $this->filterSet = $filterSet;

        return $this;
    }
}
