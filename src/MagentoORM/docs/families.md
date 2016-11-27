# Families

* [Initializing the Query Builder](#initializing-the-query-builder)
* [Initializing the Repository](#initializing-the-repository)

## Initializing the Query Builder

This object creates Doctrine DBAL `QueryBuilder` objects for entity type data fetching. It is used by repositories.

### PHP initialization

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
  kiboko_magento_connector.query_builder.family.class: Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\FamilyQueryBuilder
  
  kiboko_magento_connector.backend.family.table: 'eav_attribute_set'
  kiboko_magento_connector.backend.family.fields:
    - 'attribute_set_id'
    - 'entity_type_id'
    - 'attribute_set_name'
    - 'sort_order'

services:
  kiboko_magento_connector.query_builder.family:
    class: '%kiboko_magento_connector.query_builder.family.class%'
    arguments:
      - '@doctrine.dbal.magento_connection'
      - '%kiboko_magento_connector.backend.family.table%'
      - '%kiboko_magento_connector.backend.family.fields%'
```

## Initializing the Repository

The *Repository* objects helps you fetch data from the database.

It requires a proper *QueryBuilder* to work, see above for initializing it.

A *factory* is also required, the intialization code is provided here.

### PHP iniitalization

```php
<?php

/** @var \Doctrine\DBAL\Connection $connection */
/** @var \Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\FamilyQueryBuilderInterface $queryBuilder */

use Kiboko\Component\MagentoORM\Factory\StandardFamilyFactory;
use Kiboko\Component\MagentoORM\Repository\Doctrine\FamilyRepository;

$factory = new StandardFamilyFactory();

$familyQueryBuilder = new FamilyRepository(
    $connection,
    $queryBuilder,
    $factory
);
```

### YAML initialization

```yaml
parameters:
  kiboko_magento_connector.factory.family.class: Kiboko\Component\MagentoORM\Factory\StandardFamilyFactory
  
  kiboko_magento_connector.repository.doctrine.family.class: Kiboko\Component\MagentoORM\Repository\Doctrine\FamilyRepository

services:
  kiboko_magento_connector.factory.family:
    class: '%kiboko_magento_connector.factory.family.class%'
    
  kiboko_magento_connector.repository.doctrine.family:
    class: '%kiboko_magento_connector.repository.doctrine.family.class%'
    arguments:
      - '@doctrine.dbal.magento_connection'
      - '@kiboko_magento_connector.query_builder.family'
      - '@kiboko_magento_connector.factory.family'
```

### Using the repository

The repository has explicitly-named methods, for now 4 exist. You will need to know attribute codes or ID to load data.

```php
<?php

/** @var Kiboko\Component\MagentoORM\Repository\Doctrine\FamilyRepository $familyRepository */

// Finding one `Family` by name
$family = $familyRepository->findOneByName('Jeans');

// Finding one `Family` by id
$family = $familyRepository->findOneById(34);
```

