# Entity types

* [Initializing the Query Builder](#initializing-the-query-builder)
* [Initializing the Repository](#initializing-the-repository)

## Initializing the Query Builder

This object creates Doctrine DBAL `QueryBuilder` objects for entity type data fetching. It is used by repositories.

### PHP iniitalization

```php
<?php

/** @var \Doctrine\DBAL\Connection $connection */

use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\EntityTypeQueryBuilder;

$queryBuilder = new EntityTypeQueryBuilder(
    $connection,
    EntityTypeQueryBuilder::getDefaultTable(),
    EntityTypeQueryBuilder::getDefaultFields()
);
```

### YAML initialization

```yaml
parameters:
  kiboko.magento_driver.query_builder.entity_type.class: Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\EntityTypeQueryBuilder
  
  kiboko.magento_driver.backend.entity_type.table: 'eav_entity_type'
  kiboko.magento_driver.backend.entity_type.fields:
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
  kiboko.magento_driver.query_builder.entity_type:
    class: '%kiboko.magento_driver.query_builder.entity_type.class%'
    arguments:
      - '@database.connection'
      - '%kiboko.magento_driver.backend.entity_type.table%'
      - '%kiboko.magento_driver.backend.entity_type.fields%'
```

## Initializing the Repository

The *Repository* objects helps you fetch data from the database. It requires a proper *QueryBuilder* to work.

### PHP iniitalization

```php
<?php

use Kiboko\Component\MagentoDriver\Repository\Doctrine\EntityTypeRepository;

$entityTypeQueryBuilder = new EntityTypeRepository(
	$connection,
	$queryBuilder
);
```

### YAML initialization

```yaml
parameters:
  kiboko.magento_driver.repository.doctrine.entity_type.class: Kiboko\Component\MagentoDriver\Repository\Doctrine\EntityTypeRepository

services:
  kiboko.magento_driver.repository.doctrine.entity_type:
    class: '%kiboko.magento_driver.repository.doctrine.entity_type.class%'
    arguments:
      - '@database.connection'
      - '@kiboko.magento_driver.query_builder.entity_type'
```

### Using the repository

The repository has explicitly-named methods, for now 4 exist. You will need to know attribute codes or ID to load data.

```php
<?php

$entityType = $entityTypeRepository->findOneByCode('catalog_product');

$entityTypeList = $entityTypeRepository->findAllByCode(['catalog_product', 'catalog_category']);

$entityType = $entityTypeRepository->findOneById(3);

$entityTypeList = $entityTypeRepository->findAllById([3, 4]);

$entityTypeList = $entityTypeRepository->findAll();
```
