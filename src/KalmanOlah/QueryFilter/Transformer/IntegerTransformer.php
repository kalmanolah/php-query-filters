<?php

namespace KalmanOlah\QueryFilter\Transformer;

/**
 * A data transformer allowing conversion of strings
 * to integers.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class IntegerTransformer extends AbstractTransformer
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'i';

    /**
     * {@inheritDoc}
     */
    public function transform($value)
    {
        $value = intval($value);

        return $value;
    }
}
