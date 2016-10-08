<?php

namespace KalmanOlah\QueryFilter\MongoDB\Transformer;

use KalmanOlah\QueryFilter\Transformer\AbstractTransformer;

/**
 * A data transformer allowing conversion of strings
 * to MongoDate objects.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class MongoDateTransformer extends AbstractTransformer
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'dt';

    /**
     * {@inheritDoc}
     */
    public function transform(string $value)
    {
        $value = new \DateTime($value, new \DateTimeZone('UTC'));
        $value = new \MongoDB\BSON\UTCDateTime($value->format('U') * 1000);

        return $value;
    }
}
