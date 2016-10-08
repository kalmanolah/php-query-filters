<?php

namespace KalmanOlah\QueryFilter\Transformer;

/**
 * A data transformer allowing conversion of strings
 * to floats.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class FloatTransformer extends AbstractTransformer
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'f';

    /**
     * {@inheritDoc}
     */
    public function transform($value)
    {
        $value = floatval($value);

        return $value;
    }
}
