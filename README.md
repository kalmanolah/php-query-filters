php-query-filters
=================

php-query-filters is a library containing tools which allow for easy filtering
of queries. This is useful for people trying to create REST APIs which should
allow users to filter data by arbitrary criteria.

Currently supported are:

* Abstract:
  * Float transformer
  * Integer transformer

* Doctrine ORM QueryBuilder-based queries:
  * Automatic joins
  * GT/GTE filters
  * LT/LTE filters
  * EQ/NE filters
  * NULL/NOT NULL filters
  * LIKE filters
  * DateTime transformer

* MongoDB array-based queries:
  * GT/GTE filters
  * LT/LTE filters
  * EQ/NE filters
  * NULL/NOT NULL filters
  * LIKE filters (with $regex)
  * GEONEAR filters (point + radius)
  * OR filters (with $or)
  * MongoId transformer
  * MongoDate transformer

## Installing

Include the library in your project with composer:

```shell
$ composer require kalmanolah/php-query-filters
```

## Usage

Filtering Doctrine ORM QueryBuilder queries:

```php
use KalmanOlah\QueryFilter\FilterSet;
use KalmanOlah\QueryFilter\Transformer as Transformer;
use KalmanOlah\QueryFilter\Doctrine\ORM\Filter as DoctrineORMFilter;
use KalmanOlah\QueryFilter\Doctrine\ORM\Transformer as DoctrineORMTransformer;

// Initialize the filter set
$filterSet = (new FilterSet())
    // Register filters
    ->registerFilter(new DoctrineORMFilter\EqualsFilter())
    ->registerFilter(new DoctrineORMFilter\NotEqualsFilter())
    ->registerFilter(new DoctrineORMFilter\LikeFilter())
    ->registerFilter(new DoctrineORMFilter\FalseFilter())
    ->registerFilter(new DoctrineORMFilter\TrueFilter())
    ->registerFilter(new DoctrineORMFilter\GreaterThanFilter())
    ->registerFilter(new DoctrineORMFilter\GreaterThanOrEqualToFilter())
    ->registerFilter(new DoctrineORMFilter\LessThanFilter())
    ->registerFilter(new DoctrineORMFilter\LessThanOrEqualToFilter())
    ->registerFilter(new DoctrineORMFilter\NullFilter())
    ->registerFilter(new DoctrineORMFilter\NotNullFilter())
    // Register transformers
    ->registerTransformer(new Transformer\FloatTransformer())
    ->registerTransformer(new Transformer\IntegerTransformer())
    ->registerTransformer(new DoctrineORMTransformer\DateTimeTransformer());

// Create a query
$qb = $entityManager->createQueryBuilder()
    ->select('u')
    ->from('MyLibrary:User', 'u');

// Get some filters from somewhere (generally your REST API GET params)
// eg: GET /api/users?filter[]=foo,bar&filter[]=bar,baz
$filters = [
    'profile.firstName,eq John',   // LEFT JOIN u.profile p, WHERE p.firstName = 'John'
    'username,like adm',           // WHERE u.username LIKE '%adm%'
    'enabled,true',                // WHERE u.enabled = TRUE
    'lastLogin,gte:dt 2015-03-03', // WHERE u.lastLogin >= '2016-03-03 00:00:00'
    'karma,lt:f 3.6',              // WHERE u.karma < 3.6
];

// Apply filters to the query
$filterSet->applyQueryFilters($qb, $filters);

// Get the query result as you normally would
$result = $qb->getQuery()->getResult();
```

Filtering MongoDB array queries:

```php
use KalmanOlah\QueryFilter\FilterSet;
use KalmanOlah\QueryFilter\Transformer as Transformer;
use KalmanOlah\QueryFilter\MongoDB\Filter as MongoDBFilter;
use KalmanOlah\QueryFilter\MongoDB\Transformer as MongoDBTransformer;

// Initialize the filter set
$filterSet = (new FilterSet())
    // Register filters
    ->registerFilter(new MongoDBFilter\EqualsFilter())
    ->registerFilter(new MongoDBFilter\NotEqualsFilter())
    ->registerFilter(new MongoDBFilter\LikeFilter())
    ->registerFilter(new MongoDBFilter\FalseFilter())
    ->registerFilter(new MongoDBFilter\TrueFilter())
    ->registerFilter(new MongoDBFilter\GreaterThanFilter())
    ->registerFilter(new MongoDBFilter\GreaterThanOrEqualToFilter())
    ->registerFilter(new MongoDBFilter\LessThanFilter())
    ->registerFilter(new MongoDBFilter\LessThanOrEqualToFilter())
    ->registerFilter(new MongoDBFilter\NullFilter())
    ->registerFilter(new MongoDBFilter\NotNullFilter())
    ->registerFilter(new MongoDBFilter\GeoNearFilter())
    ->registerFilter(new MongoDBFilter\OrFilter())
    // Register transformers
    ->registerTransformer(new Transformer\FloatTransformer())
    ->registerTransformer(new Transformer\IntegerTransformer())
    ->registerTransformer(new MongoDBTransformer\MongoIdTransformer())
    ->registerTransformer(new MongoDBTransformer\MongoDateTransformer());

// Create a query (Note: the $and key is currently required)
$query = [
    '$and' => [],
];

// Get some filters from somewhere (generally your REST API GET params)
// eg: GET /api/users?filter[]=foo,bar&filter[]=bar,baz
$filters = [
    '*,or 1,2,3',                           // Wrap filters with index 1, 2 and 3 in OR statement
    'profile.firstName,eq John',            // ['profile.firstName' => ['$eq' => 'John']]
    'username,like adm',                    // ['username' => ['$regex' => /adm/i]]
    'enabled,true',                         // ['enabled' => ['$eq' => true]]
    'lastLogin,gte:dt 2015-03-03',          // ['lastLogin' => ['$gte' => ISODate('2015-03-03T00:00:00Z')]]
    'id,ne:id 123412341234123412341234',    // ['id' => ['$ne' => ObjectId('123412341234')]]
    'karma,lt:f 3.6',                       // ['karma' => ['$lt' => 3.6]]
    'location,geo_near 4.4500,51.1333,300', // ['location' => ['$near' => ...]]
];

// Apply filters to the query
$filterSet->applyQueryFilters($query, $filters);

// Get the query result as you normally would
$mongo = new MongoDB\Client("mongodb://localhost:27017");
$result = $mongo->mydb->user->find($query);
```

## Testing

Run the tests after you've ran a composer install:

```shell
$ ./scripts/run_tests
```

## License

See [LICENSE](LICENSE)
