<?php

namespace KalmanOlah\QueryFilter\Doctrine\ORM\Filter;

use KalmanOlah\QueryFilter\Filter\FilterInterface;

/**
 * An interface defining the behaviour of a Doctrine ORM filter.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
interface DoctrineORMFilterInterface extends FilterInterface
{
    /**
     * Generate a statement for the given value and given field,
     * to be applied to the given query.
     *
     * A statement is an associative array consisting of the following keys:
     *   * query:      An array of strings to be added to the WHERE statement
     *                 of the querybuilder (using the `andWhere` method)
     *   * parameters: An associative array of parameters to be added to the querybuilder
     *                 (using the `setParameter` method)
     *
     * @param  mixed  &$query   Query to filter.
     * @param  array  &$filters Parsed filters to be applied.
     * @param  string $field    Field to filter on.
     * @param  mixed  $value    Value to filter on.
     * @return array<string,array>
     */
    public function generateStatement(&$query, &$filters, $field, $value);
}
