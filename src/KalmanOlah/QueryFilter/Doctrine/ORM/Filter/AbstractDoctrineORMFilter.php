<?php

namespace KalmanOlah\QueryFilter\Doctrine\ORM\Filter;

use KalmanOlah\QueryFilter\Filter\AbstractFilter;
use KalmanOlah\QueryFilter\Exception\InvalidFilterException;

/**
 * A base implementation of a Doctrine ORM filter,
 * allowing for easy extension.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
abstract class AbstractDoctrineORMFilter extends AbstractFilter
{
    /**
     * Resolve a field string to an actual alias for a
     * field usable in the given query.
     *
     * For instance, strings such as "user.profile.firstName"
     * may add joins for the "user" and "profile" associations
     * to the query, and return the alias "p.firstName".
     *
     * @param  mixed  &$query Query to filter.
     * @param  string $field  Field to filter on.
     * @return string
     */
    protected function resolveFieldAlias(&$query, $field)
    {
        // Attempt to split the field into parts
        $parts = explode('.', $field);

        $entityManager = $query->getEntityManager();
        $metadataFactory = $entityManager->getMetadataFactory();

        // The last part should be the actual field identifier
        // Example: "user.profile.firstName" => "firstName"
        $field = array_pop($parts);

        // We initialize the active alias as the first root
        // alias of the query.
        // For the query "SELECT u from MyLib:User u" this would be "u"
        $activeAlias = $query->getRootAliases()[0];

        // We initialize the active class metadata
        // for the first root entity of the query.
        $activeMetadata = $metadataFactory->getMetadataFor($query->getRootEntities()[0]);

        // Iterate over parts requiring joins
        foreach ($parts as $part) {
            // Ensure an association with the given name exists
            if (!$activeMetadata->hasAssociation($part)) {
                throw new InvalidFilterException(sprintf('No association with the name "%s" exists for the class "%s"', $part, $activeMetadata->getName()));
            }

            // Generate an alias for the join we're about to perform
            // Note: the generated alias needs to depend on all
            // aliases used in joins that came before it in order
            // to detect duplicate joins before they happen
            $alias = sprintf('%s__%s', $activeAlias, $part);

            // If the alias is not yet taken, perform the join
            $aliases = $query->getAllAliases();
            if (!in_array($alias, $aliases)) {
                $query->leftJoin(sprintf('%s.%s', $activeAlias, $part), $alias);
            }

            // Set active alias and metadata for the next iteration
            $activeAlias = $alias;
            $targetEntity = $activeMetadata->getAssociationMapping($part)['targetEntity'];
            $activeMetadata = $metadataFactory->getMetadataFor($targetEntity);
        }

        // Our final field alias if the last used entity alias and the actual field name
        $field = sprintf('%s.%s', $activeAlias, $field);

        return $field;
    }

    /**
     * Generate a parameter/placeholder name.
     *
     * @return string
     */
    protected function generateParameterName()
    {
        return sprintf('QF_%s', hash('crc32', uniqid('', true).microtime(true)));
    }
}
