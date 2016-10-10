<?php

namespace KalmanOlah\QueryFilter\MongoDB\Filter;

use KalmanOlah\QueryFilter\Filter\AbstractFilter;
use KalmanOlah\QueryFilter\Exception\InvalidFilterException;

/**
 * A filter allowing filtering by checking whether the field
 * contains a value (a location) geographically near the given
 * value (a location).
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class GeoNearFilter extends AbstractFilter
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'geo_near';

    /**
     * {@inheritDoc}
     */
    public function filter(&$query, &$filters, $field, $value)
    {
       try {
            list($longitude, $latitude, $radius) = explode(',', $value);
        } catch (\Exception $e) {
            throw new InvalidFilterException(sprintf('The value "%s" provided for the GeoNearFilter is not in the required "$longitude,$latitude,$radius" format.', $value));
        }

        $radius = floatval($radius);
        $longitude = floatval($longitude);
        $latitutde = floatval($latitude);

        $geometry = [
            'type'        => 'Point',
            'coordinates' => [$longitude, $latitude],
        ];

        $query['$and'][] = [
            $field => [
                '$near' => [
                    '$minDistance' => 0,
                    '$maxDistance' => $radius,
                    '$geometry'    => $geometry,
                ],
            ],
        ];
    }
}
