# Families

* [Initializing the Query Builder](#initializing-the-query-builder)
* [Initializing the Repository](#initializing-the-repository)

## Initializing the Query Builder

his object creates Doctrine DBAL `QueryBuilder` objects for entity type data fetching. It is used by repositories.

### PHP iniitalization

```php
<?php

/** @var \Doctrine\DBAL\Connection $connection */

use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\FamilyQueryBuilder;

$queryBuilder = new FamilyQueryBuilder(
    $connection,
    FamilyQueryBuilder::getDefaultTable(),
    FamilyQueryBuilder::getDefaultFields()
);
```

### YAML initialization

```yaml
parameters:
  kiboko.magento_driver.query_builder.family.class: Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\FamilyQueryBuilder
  
  kiboko.magento_driver.backend.family.table: 'eav_attribute_set'
  kiboko.magento_driver.backend.family.fields:
	- attribute_set_id
	- entity_type_id
	- attribute_set_name
	- sort_order

services:
  kiboko.magento_driver.query_builder.family:
    class: '%kiboko.magento_driver.query_builder.family.class%'
    arguments:
      - '@database.connection'
      - '%kiboko.magento_driver.backend.family.table%'
      - '%kiboko.magento_driver.backend.family.fields%'
```

## Initializing the Repository

The *Repository* objects helps you fetch data from the database. It requires a proper *QueryBuilder* to work.

### PHP iniitalization

```php
<?php

use Kiboko\Component\MagentoORM\Factory\StandardFamilyFactory;
use Kiboko\Component\MagentoORM\Repository\Doctrine\FamilyRepository;

$familyFactory = new StandardFamilyFactory();

$familyQueryBuilder = new FamilyRepository(
	$connection,
	$queryBuilder,
	familyFactory
);
```

### YAML initialization

```yaml
parameters:
  kiboko.magento_driver.repository.doctrine.family.class: Kiboko\Component\MagentoORM\Repository\Doctrine\FamilyRepository
  kiboko.magento_driver.factory.family.class: Kiboko\Component\MagentoORM\Factory\StandardFamilyFactory

services:
  kiboko.magento_driver.factory.family:
    class: '%kiboko.magento_driver.factory.family.class%'
    
  kiboko.magento_driver.repository.doctrine.family:
    class: '%kiboko.magento_driver.repository.doctrine.family.class%'
    arguments:
      - '@database.connection'
      - '@kiboko.magento_driver.query_builder.family'
      - '@kiboko.magento_driver.factory.family'
```

### Using the repository

The repository has explicitly-named methods, for now 4 exist. You will need to know attribute codes or ID to load data.

```php
<?php

$family = $familyRepository->findOneByName('Jeans');

$family = $familyRepository->findOneById(34);
```

### Don't forget the Factory

In order to make the repository build `Family` objects, we need an object factory. The default one will provide you basic functionality, you will be able to enhance it by implementing a replacement.
