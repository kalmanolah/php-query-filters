<?php

namespace KalmanOlah\QueryFilter\MongoDB\Transformer;

use KalmanOlah\QueryFilter\Transformer\AbstractTransformer;

/**
 * A data transformer allowing conversion of strings
 * to MongoId objects.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class MongoIdTransformer extends AbstractTransformer
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'id';

    /**
     * {@inheritDoc}
     */
    public function transform(string $value)
    {
        $value = new \MongoDB\BSON\ObjectId($value);

        return $value;
    }
}
