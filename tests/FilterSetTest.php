<?php

namespace KalmanOlah\QueryFilter\Tests;

use KalmanOlah\QueryFilter\FilterSet;
use KalmanOlah\QueryFilter\Transformer;
use KalmanOlah\QueryFilter\Doctrine\ORM\Transformer as DoctrineORMTransformer;
use KalmanOlah\QueryFilter\Doctrine\ORM\Filter as DoctrineORMFilter;
use KalmanOlah\QueryFilter\MongoDB\Transformer as MongoDBTransformer;
use KalmanOlah\QueryFilter\MongoDB\Filter as MongoDBFilter;



/**
 * Basic test testing core functionality.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 */
class FilterSetTest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiate()
    {
        $set = new FilterSet();
    }

    public function testCoreTransformerRegistration()
    {
        $set = new FilterSet();
        $set->registerTransformer(new Transformer\IntegerTransformer());
        $set->registerTransformer(new Transformer\FloatTransformer());
    }

    public function testCoreFilterRegistration()
    {
        $set=  new FilterSet();
    }

    public function testMongoDBTransformerRegistration()
    {
        $set = new FilterSet();
        $set->registerTransformer(new MongoDBTransformer\MongoIdTransformer());
        $set->registerTransformer(new MongoDBTransformer\MongoDateTransformer());
    }

    public function testDoctrineORMTransformerRegistration()
    {
        $set = new FilterSet();
        $set->registerTransformer(new DoctrineORMTransformer\DateTimeTransformer());
    }

    public function testMongoDBFilterRegistration()
    {
        $set = new FilterSet();
        $set->registerFilter(new MongoDBFilter\EqualsFilter());
        $set->registerFilter(new MongoDBFilter\NotEqualsFilter());
        $set->registerFilter(new MongoDBFilter\LikeFilter());
        $set->registerFilter(new MongoDBFilter\FalseFilter());
        $set->registerFilter(new MongoDBFilter\TrueFilter());
        $set->registerFilter(new MongoDBFilter\GreaterThanFilter());
        $set->registerFilter(new MongoDBFilter\GreaterThanOrEqualToFilter());
        $set->registerFilter(new MongoDBFilter\LessThanFilter());
        $set->registerFilter(new MongoDBFilter\LessThanOrEqualToFilter());
        $set->registerFilter(new MongoDBFilter\NullFilter());
        $set->registerFilter(new MongoDBFilter\NotNullFilter());
        $set->registerFilter(new MongoDBFilter\GeoNearFilter());
    }

    public function testDoctrineORMFilterRegistration()
    {
        $set = new FilterSet();
        $set->registerFilter(new DoctrineORMFilter\EqualsFilter());
        $set->registerFilter(new DoctrineORMFilter\NotEqualsFilter());
        $set->registerFilter(new DoctrineORMFilter\LikeFilter());
        $set->registerFilter(new DoctrineORMFilter\FalseFilter());
        $set->registerFilter(new DoctrineORMFilter\TrueFilter());
        $set->registerFilter(new DoctrineORMFilter\GreaterThanFilter());
        $set->registerFilter(new DoctrineORMFilter\GreaterThanOrEqualToFilter());
        $set->registerFilter(new DoctrineORMFilter\LessThanFilter());
        $set->registerFilter(new DoctrineORMFilter\LessThanOrEqualToFilter());
        $set->registerFilter(new DoctrineORMFilter\NullFilter());
        $set->registerFilter(new DoctrineORMFilter\NotNullFilter());
    }

    public function testMongoDBFiltering()
    {
        $set = new FilterSet();
        $set->registerFilter(new MongoDBFilter\EqualsFilter());
        $set->registerFilter(new MongoDBFilter\NotEqualsFilter());
        $set->registerFilter(new MongoDBFilter\LikeFilter());
        $set->registerFilter(new MongoDBFilter\FalseFilter());
        $set->registerFilter(new MongoDBFilter\TrueFilter());
        $set->registerFilter(new MongoDBFilter\GreaterThanFilter());
        $set->registerFilter(new MongoDBFilter\GreaterThanOrEqualToFilter());
        $set->registerFilter(new MongoDBFilter\LessThanFilter());
        $set->registerFilter(new MongoDBFilter\LessThanOrEqualToFilter());
        $set->registerFilter(new MongoDBFilter\NullFilter());
        $set->registerFilter(new MongoDBFilter\NotNullFilter());
        $set->registerFilter(new MongoDBFilter\GeoNearFilter());
        $set->registerTransformer(new Transformer\FloatTransformer());
        $set->registerTransformer(new MongoDBTransformer\MongoIdTransformer());
        $set->registerTransformer(new MongoDBTransformer\MongoDateTransformer());

        $query = [
            '$and' => [],
        ];

        $filters = [
            'profile.firstName,eq John',            // ['profile.firstName' => ['$eq' => 'John']]
            'username,like adm',                    // ['username' => ['$regex' => /adm/i]]
            'enabled,true',                         // ['enabled' => ['$eq' => true]]
            'lastLogin,gte:dt 2015-03-03',          // ['lastLogin' => ['$gte' => ISODate('2015-03-03T00:00:00Z')]]
            'id,ne:id 123412341234123412341234',    // ['id' => ['$ne' => ObjectId('123412341234')]]
            'karma,lt:f 3.6',                       // ['karma' => ['$lt' => 3.6]]
            'location,geo_near 4.4500,51.1333,300', // ['location' => ['$near' => ...]]
        ];

        $set->applyQueryFilters($query, $filters);
    }
}
