<?php

namespace KalmanOlah\QueryFilter\Doctrine\ORM\Filter;

/**
 * A filter allowing filtering by checking whether the field
 * contains a specific value.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class EqualsFilter extends AbstractDoctrineORMFilter
{
    /**
     * {@inheritDoc}
     */
    protected $id = 'eq';

    /**
     * {@inheritDoc}
     */
    public function generateStatement(&$query, &$filters, $field, $value)
    {
        $param = $this->generateParameterName();
        $field = $this->resolveFieldAlias($query, $field);

        return [
            'query'      => [sprintf('%s = :%s', $field, $param)],
            'parameters' => [$param => $value],
        ];
    }
}
