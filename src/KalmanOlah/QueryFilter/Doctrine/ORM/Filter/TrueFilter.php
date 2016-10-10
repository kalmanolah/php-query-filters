<?php

namespace KalmanOlah\QueryFilter\Doctrine\ORM\Filter;

/**
 * A filter allowing filtering by checking whether the field
 * contains the boolean value "true".
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class TrueFilter extends AbstractDoctrineORMFilter
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'true';

    /**
     * {@inheritDoc}
     */
    public function generateStatement(&$query, &$filters, $field, $value)
    {
        $field = $this->resolveFieldAlias($query, $field);

        return [
            'query'      => [sprintf('%s = TRUE', $field)],
            'parameters' => [],
        ];
    }
}
