# Entity types

* [Initializing the Query Builder](#initializing-the-query-builder)
* [Initializing the Repository](#initializing-the-repository)

## Initializing the Query Builder

This object creates Doctrine DBAL `QueryBuilder` objects for entity type data fetching. It is used by repositories.

### PHP initialization

```php
<?php

/** @var \Doctrine\DBAL\Connection $connection */

use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\EntityTypeQueryBuilder;

$queryBuilder = new EntityTypeQueryBuilder(
    $connection,
    EntityTypeQueryBuilder::getDefaultTable(),
    EntityTypeQueryBuilder::getDefaultFields()
);
```

### YAML initialization

```yaml
parameters:
  kiboko_magento_connector.query_builder.entity_type.class: Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\EntityTypeQueryBuilder

  kiboko_magento_connector.backend.entity_type.table: 'eav_entity_type'
  kiboko_magento_connector.backend.entity_type.fields:
    - 'entity_type_id'
    - 'entity_type_code'
    - 'entity_model'
    - 'attribute_model'
    - 'entity_table'
    - 'value_table_prefix'
    - 'entity_id_field'
    - 'is_data_sharing'
    - 'data_sharing_key'
    - 'default_attribute_set_id'
    - 'increment_model'
    - 'increment_per_store'
    - 'increment_pad_length'
    - 'increment_pad_char'
    - 'additional_attribute_table'
    - 'entity_attribute_collection'

services:
  kiboko_magento_connector.query_builder.entity_type:
    class: '%kiboko_magento_connector.query_builder.entity_type.class%'
    arguments:
      - '@doctrine.dbal.magento_connection'
      - '%kiboko_magento_connector.backend.entity_type.table%'
      - '%kiboko_magento_connector.backend.entity_type.fields%'
```

## Initializing the Repository

The *Repository* objects helps you fetch data from the database.

It requires a proper *QueryBuilder* to work, see above for initializing it.

A *factory* is also required, the intialization code is provided here.

### PHP iniitalization

```php
<?php

/** @var \Doctrine\DBAL\Connection $connection */
/** @var \Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\EntityTypeQueryBuilderInterface $queryBuilder */

use Kiboko\Component\MagentoORM\Factory\StandardEntityTypeFactory;
use Kiboko\Component\MagentoORM\Repository\Doctrine\EntityTypeRepository;

$factory = new StandardEntityTypeFactory();

$entityTypeRepository = new EntityTypeRepository(
    $connection,
    $queryBuilder,
    $factory
);
```

### YAML initialization

```yaml
parameters:
  kiboko_magento_connector.factory.entity_type.class:             Kiboko\Component\MagentoORM\Factory\StandardEntityTypeFactory
  
  kiboko_magento_connector.repository.doctrine.entity_type.class: Kiboko\Component\MagentoORM\Repository\Doctrine\EntityTypeRepository

services:
  kiboko_magento_connector.factory.entity_type:
    class: '%kiboko_magento_connector.factory.entity_type.class%'

  kiboko_magento_connector.repository.doctrine.entity_type:
    class: '%kiboko_magento_connector.repository.doctrine.entity_type.class%'
    arguments:
      - '@doctrine.dbal.magento_connection'
      - '@kiboko_magento_connector.query_builder.entity_type'
      - '@kiboko_magento_connector.factory.entity_type'
```

### Using the repository

The repository has explicitly-named methods, for now 4 exist. You will need to know attribute codes or ID to load data.

```php
<?php

/** @var Kiboko\Component\MagentoORM\Repository\Doctrine\EntityTypeRepository $entityTypeRepository */

// Finding one `EntityType` by code
$entityType = $entityTypeRepository->findOneByCode('catalog_product');

// Finding multiple `EntityType` by code
$entityTypeList = $entityTypeRepository->findAllByCode(['catalog_product', 'catalog_category']);

// Finding one `EntityType` by id
$entityType = $entityTypeRepository->findOneById(3);

// Finding multiple `EntityType` by id
$entityTypeList = $entityTypeRepository->findAllById([3, 4]);

// Finding all `EntityType`
$entityTypeList = $entityTypeRepository->findAll();
```
