# Product attributes

* [Initializing the Query Builder](#initializing-the-query-builder)
* [Initializing the Repository](#initializing-the-repository)
* [Using the Cached Repository](#using-the-cached-repository)
* [Persisting data](#persisting-data)
  * [Portable DML](#portable-dml)
  * [MySQL specific, CSV direct importer](#mysql-specific-csv-direct-importer)
* [Deleting data](#deleting-data)

## Initializing the Query Builder

This object creates Doctrine DBAL `QueryBuilder` objects for product attribute data manipulation. It is mainly used by repositories and deleters.

### PHP iniitalization

```php
<?php

/** @var \Doctrine\DBAL\Connection $connection */

use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilder;

$queryBuilder = new ProductAttributeQueryBuilder(
    $connection,
    ProductAttributeQueryBuilder::getDefaultTable(),
    ProductAttributeQueryBuilder::getDefaultExtraTable(),
    ProductAttributeQueryBuilder::getDefaultEntityTable(),
    ProductAttributeQueryBuilder::getDefaultVariantTable(),
    ProductAttributeQueryBuilder::getDefaultFamilyTable(),
    ProductAttributeQueryBuilder::getDefaultFields(),
    ProductAttributeQueryBuilder::getDefaultExtraFields()
);
```

### YAML initialization

```yaml
parameters:
  kiboko.magento_driver.query_builder.product_attribute.class:       Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilder
  
  kiboko.magento_driver.backend.attribute.standard.table: 'eav_attribute'
  kiboko.magento_driver.backend.attribute.catalog_extras.table: 'catalog_eav_attribute'
  kiboko.magento_driver.backend.attribute.catalog_entity.table: 'eav_entity_type'
  kiboko.magento_driver.backend.attribute.variant_axis.table: 'catalog_product_super_attribute'
  kiboko.magento_driver.backend.attribute.family.table: 'eav_attribute_set'
  kiboko.magento_driver.backend.attribute.standard.fields:
    - 'attribute_id'
    - 'attribute_code'
    - 'attribute_model'
    - 'backend_model'
    - 'backend_type'
    - 'backend_table'
    - 'frontend_model'
    - 'frontend_input'
    - 'frontend_label'
    - 'frontend_class'
    - 'source_model'
    - 'is_required'
    - 'is_user_defined'
    - 'default_value'
    - 'is_unique'
  kiboko.magento_driver.backend.attribute.catalog_extras.fields:
    - 'frontend_input_renderer'
    - 'is_global'
    - 'is_visible'
    - 'is_searchable'
    - 'is_filterable'
    - 'is_comparable'
    - 'is_visible_on_front'
    - 'is_html_allowed_on_front'
    - 'is_used_for_price_rules'
    - 'is_filterable_in_search'
    - 'used_in_product_listing'
    - 'used_for_sort_by'
    - 'is_configurable'
    - 'apply_to'
    - 'is_visible_in_advanced_search'
    - 'position'
    - 'is_wysiwyg_enabled'
    - 'is_used_for_promo_rules'
  
services:
  kiboko.magento_driver.query_builder.product_attribute:
    class: '%kiboko.magento_driver.query_builder.product_attribute.class%'
    arguments:
      - '@database.connection'
      - '%kiboko.magento_driver.backend.attribute.standard.table%'
      - '%kiboko.magento_driver.backend.attribute.catalog_extras.table%'
      - '%kiboko.magento_driver.backend.attribute.catalog_entity.table%'
      - '%kiboko.magento_driver.backend.attribute.variant_axis.table%'
      - '%kiboko.magento_driver.backend.attribute.family.table%'
      - '%kiboko.magento_driver.backend.attribute.standard.fields%'
      - '%kiboko.magento_driver.backend.attribute.catalog_extras.fields%'
```

## Initializing the Repository

The *Repository* objects helps you fetch data from the database. It requires a proper *QueryBuilder* to work.

### PHP iniitalization

```php
<?php

use Luni\Component\MagentoDriver\Repository\Doctrine\ProductAttributeRepository;

$productAttributeRepository = new ProductAttributeRepository(
    $connection,
    $queryBuilder
);
```

### YAML initialization

```yaml
parameters:
  kiboko.magento_driver.repository.catalog_attribute.class:       Kiboko\Component\MagentoDriver\Repository\Doctrine\CatalogAttributeRepository

services:
  kiboko.magento_driver.repository.catalog_attribute:
    class: '%kiboko.magento_driver.repository.catalog_attribute.class%'
    arguments:
      - '@database.connection'
      - '@kiboko.magento_driver.query_builder.product_attribute'
```

### Using the repository

The repository has explicitly-named methods, for now 4 exist. You will need to know attribute codes or ID to load data.

```php
<?php

$attribute = $productAttributeRepository->findOneByCode('sku');

$attributeList = $productAttributeRepository->findAllByCode(['sku', 'image', 'name']);

$attribute = $productAttributeRepository->findOneById(74);

$attributeList = $productAttributeRepository->findAllById([74, 71, 85]);
```

## Using the Cached Repository

There is a cached repository which will request only attribute data that haven't already been requested.

### PHP Initialization

```php
<?php

use Kiboko\Component\MagentoDriver\Repository\CachedRepository\CachedProductAttributeRepository;

$cachedProductAttributeRepository = new CachedProductAttributeRepository($productAttributeRepository);
```

### YAML initialization

```yaml
parameters:
  kiboko.magento_driver.repository.cached.catalog_attribute.class: Kiboko\Component\MagentoDriver\Repository\CachedRepository\CachedProductAttributeRepository
  
services:
  kiboko.magento_driver.repository.cached.catalog_attribute:
    class: '%kiboko.magento_driver.repository.cached.catalog_attribute.class%'
    arguments:
      - '@kiboko.magento_driver.repository.doctrine.catalog_attribute.class'
```

## Persisting data

There is currently 2 ways of importing data : the standard and portable *DML* way, using `INSERT` and `UPDATE` queries. The second is *MySQL* specific and is an order of magnitude faster when you need to do large imports.

Concerning product attributes, data are stored in 2 tables. To address this you need 2 persisters : one for the standard attribute values and one for catalog specific attribute options. To keep things simple, a facade object will keep hard things hidden.

### Portable DML

#### PHP initialization

```php
<?php

use Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute\StandardAttributePersister;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute\CatalogAttributeExtensionPersister;
use Kiboko\Component\MagentoDriver\Persister\CatalogAttributePersister;

$standardAttributePersister = new StandardAttributePersister(
    $connection,
    ProductAttributeQueryBuilder::getDefaultTable(),
);

$catalogAttributeExtensionsPersister = new CatalogAttributeExtensionPersister(
    $connection,
    ProductAttributeQueryBuilder::getDefaultTable(),
);

$cataogAttributePersister = new CatalogAttributePersister(
	$standardAttributePersister,
	$catalogAttributeExtensionsPersister
);
```

#### YAML initialization

```yaml
parameters:
  kiboko.magento_driver.persister.standard_dml.attribute.standard.class: Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute\StandardAttributePersister
  kiboko.magento_driver.persister.standard_dml.attribute.catalog_extras.class:  Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute\CatalogAttributeExtensionPersister
  kiboko.magento_driver.persister.standard_dml.attribute.catalog.class:  Kiboko\Component\MagentoDriver\Persister\CatalogAttributePersister
  
  kiboko.magento_driver.backend.attribute.standard.table: 'eav_attribute'
  kiboko.magento_driver.backend.attribute.catalog_extras.table: 'catalog_eav_attribute'
  
services:
  kiboko.magento_driver.persister.standard_dml.attribute.standard:
    class: '%kiboko.magento_driver.persister.standard_dml.attribute.standard.class%'
    arguments:
      - '@database.connection'
      - '%kiboko.magento_driver.backend.attribute.standard.table%'

  kiboko.magento_driver.persister.standard_dml.attribute.catalog_extras:
    class: '%kiboko.magento_driver.persister.standard_dml.attribute.catalog_extras.class%'
    arguments:
      - '@database.connection'
      - '%kiboko.magento_driver.backend.attribute.catalog_extras.table%'

  kiboko.magento_driver.persister.standard_dml.attribute.catalog:
    class: '%kiboko.magento_driver.persister.standard_dml.attribute.catalog.class%'
    arguments:
      - '@kiboko.magento_driver.persister.standard_dml.attribute.standard'
      - '@kiboko.magento_driver.persister.standard_dml.attribute.catalog_extras'
```

#### MySQL specific, CSV direct importer

The CSV direct importer requires some more configuration, as long as data can be written on a remote server, transferred either directly by MySQL or by another tool.

`@TODO`

### Using the persister

```php
<?php
// Starting the persiting process
$cataogAttributePersister->initialize();

// Walking every every attribute in the list to persist and add them
// to the data to persist
foreach ($data as $attribute) {
    $cataogAttributePersister->persist($attribute);
}

// Actual data persisting, flush data from the buffer and send it to
// the database
$cataogAttributePersister->flush();
```

## Deleting data

Deleting data is made easy by the *Deleter*. It works quite similarily as the *Repository*, and requires a *QueryBuilder*.

### PHP initialization

```php
<?php

use Kiboko\Component\MagentoDriver\Deleter\Doctrine\AttributeDeleter;

new AttributeDeleter(
    $conneciton,
    $queryBuilder
);
```

### YAML initialization

```yaml
parameters:
  kiboko.magento_driver.deleter.attribute.class: Kiboko\Component\MagentoDriver\Deleter\Doctrine\AttributeDeleter
sevices:
  kiboko.magento_driver.deleter.attribute:
    class: '%kiboko.magento_driver.deleter.attribute.class%'
    arguments:
      - '@database.connection'
      - '@kiboko.magento_driver.query_builder.attribute'
```

### Using the deleter

Aslike the *Repository*, the *Deleter* has explicitly-named methods, for now 4 exist. You will need to know attribute codes or ID to delete data.

```php
<?php

$deleter->deleteOneById(72);

$deleter->deleteAllById([72, 56, 234]);

$deleter->deleteOneByCode('shoe_size');

$deleter->deleteAllByCode(['shoe_size', 'heel_height']);
```