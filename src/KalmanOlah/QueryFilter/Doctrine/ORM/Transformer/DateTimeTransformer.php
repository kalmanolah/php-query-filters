<?php

namespace KalmanOlah\QueryFilter\Doctrine\ORM\Transformer;

use KalmanOlah\QueryFilter\Transformer\AbstractTransformer;

/**
 * A data transformer allowing conversion of strings
 * to datetime strings usable in Doctrine ORM queries.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class DateTimeTransformer extends AbstractTransformer
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'dt';

    /**
     * {@inheritDoc}
     */
    public function transform($value)
    {
        $value = new \DateTime($value, new \DateTimeZone('UTC'));
        $value = $value->format('Y-m-d H:i:s');

        return $value;
    }
}
