# Product attributes

* [Initializing the Query Builder](#initializing-the-query-builder)
* [Initializing the Repository](#initializing-the-repository)
* [Using the Cached Repository](#using-the-cached-repository)
* [Persisting data](#persisting-data)
  * [Portable DML](#portable-dml)
  * [MySQL specific, CSV direct importer](#mysql-specific-csv-direct-importer)
* [Deleting data](#deleting-data)

## Initializing the Query Builder

This object creates Doctrine DBAL `QueryBuilder` objects for product attribute data manipulation. It is used by repositories and deleters.

### PHP initialization

```php
<?php

/** @var \Doctrine\DBAL\Connection $connection */

use Kiboko\Component\MagentoORM\QueryBuilder\V2_0ce\Doctrine\ProductAttributeQueryBuilder;

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
  kiboko_magento_connector.query_builder.product_attribute.class: Kiboko\Component\MagentoORM\QueryBuilder\V2_0ce\Doctrine\ProductAttributeQueryBuilder
  
  kiboko_magento_connector.backend.attribute.standard.table: 'eav_attribute'
  kiboko_magento_connector.backend.attribute.catalog_extras.table: 'catalog_eav_attribute'
  kiboko_magento_connector.backend.attribute.catalog_entity.table: 'eav_entity_type'
  kiboko_magento_connector.backend.attribute.variant_axis.table: 'catalog_product_super_attribute'
  kiboko_magento_connector.backend.attribute.family.table: 'eav_attribute_set'
  kiboko_magento_connector.backend.attribute.standard.fields:
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
  kiboko_magento_connector.backend.attribute.catalog_extras.fields:
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
    - 'apply_to'
    - 'is_visible_in_advanced_search'
    - 'position'
    - 'is_wysiwyg_enabled'
    - 'is_used_for_promo_rules'
    - 'is_required_in_admin_store'
    - 'is_used_in_grid'
    - 'is_visible_in_grid'
    - 'is_filterable_in_grid'
    - 'search_weight'
    - 'additional_data'
    - 'note'
  
services:
  kiboko_magento_connector.query_builder.product_attribute:
    class: '%kiboko_magento_connector.query_builder.product_attribute.class%'
    arguments:
      - '@doctrine.dbal.magento_connection'
      - '%kiboko_magento_connector.backend.attribute.standard.table%'
      - '%kiboko_magento_connector.backend.attribute.catalog_extras.table%'
      - '%kiboko_magento_connector.backend.attribute.catalog_entity.table%'
      - '%kiboko_magento_connector.backend.attribute.variant_axis.table%'
      - '%kiboko_magento_connector.backend.attribute.family.table%'
      - '%kiboko_magento_connector.backend.attribute.standard.fields%'
      - '%kiboko_magento_connector.backend.attribute.catalog_extras.fields%'
```

## Initializing the Repository

The *Repository* objects helps you fetch data from the database.

It requires a proper *QueryBuilder* to work.

### PHP initialization

```php
<?php

/** @var \Doctrine\DBAL\Connection $connection */
/** @var \Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\ProductAttributeQueryBuilderInterface $queryBuilder */

use Kiboko\Component\MagentoORM\Repository\Doctrine\ProductAttributeRepository;
use Kiboko\Component\MagentoORM\Factory\AttributeFactory;
use Kiboko\Component\MagentoORM\Factory\V2_0ce\CatalogAttributeExtensionsFactory;
use Kiboko\Component\MagentoORM\Factory\V2_0ce\ProductAttributeFactory;

$factory = new ProductAttributeFactory(
    new AttributeFactory(),
    new CatalogAttributeExtensionsFactory()
);

$productAttributeRepository = new ProductAttributeRepository(
    $connection,
    $queryBuilder,
    $factory
);
```

### YAML initialization

```yaml
parameters:
  kiboko_magento_connector.factory.attribute.class:                    Kiboko\Component\MagentoORM\Factory\AttributeFactory
  kiboko_magento_connector.factory.catalog_attribute_extensions.class: Kiboko\Component\MagentoORM\Factory\V2_0ce\CatalogAttributeExtensionsFactory
  kiboko_magento_connector.factory.catalog_attribute.class:            Kiboko\Component\MagentoORM\Factory\V2_0ce\ProductAttributeFactory
  
  kiboko_magento_connector.repository.catalog_attribute.class: Kiboko\Component\MagentoORM\Repository\Doctrine\ProductAttributeRepository

services:
  kiboko_magento_connector.factory.attribute:
    class: '%kiboko_magento_connector.factory.attribute.class%'
    
  kiboko_magento_connector.factory.catalog_attribute_extensions:
    class: '%kiboko_magento_connector.factory.catalog_attribute_extensions.class%'
    
  kiboko_magento_connector.factory.catalog_attribute:
    class: '%kiboko_magento_connector.factory.catalog_attribute.class%'
    arguments:
      - '@kiboko_magento_connector.factory.attribute'
      - '@kiboko_magento_connector.factory.catalog_attribute_extensions'

  kiboko_magento_connector.repository.catalog_attribute:
    class: '%kiboko_magento_connector.repository.catalog_attribute.class%'
    arguments:
      - '@database.connection'
      - '@kiboko_magento_connector.query_builder.product_attribute'
      - '@kiboko_magento_connector.factory.catalog_attribute'
```

### Using the repository

The repository has explicitly-named methods, for now 4 exist. You will need to know attribute codes or ID to load data.

```php
<?php

/** @var Kiboko\Component\MagentoORM\Repository\Doctrine\ProductAttributeRepository $productAttributeRepository */

$attribute = $productAttributeRepository->findOneByCode('sku', 'catalog_product');

$attributeList = $productAttributeRepository->findAllByCode('catalog_product', ['sku', 'image', 'name']);

$attribute = $productAttributeRepository->findOneById(74);

$attributeList = $productAttributeRepository->findAllById([74, 71, 85]);
```

## Using the Cached Repository

There is a cached repository which will request only attribute data that haven't already been requested.

### PHP Initialization

```php
<?php

/** @var Kiboko\Component\MagentoORM\Repository\Doctrine\ProductAttributeRepository $productAttributeRepository */

use Kiboko\Component\MagentoORM\Repository\CachedRepository\CachedProductAttributeRepository;

$cachedProductAttributeRepository = new CachedProductAttributeRepository($productAttributeRepository);
```

### YAML initialization

```yaml
parameters:
  kiboko_magento_connector.repository.cached.catalog_attribute.class: Kiboko\Component\MagentoORM\Repository\CachedRepository\CachedProductAttributeRepository
  
services:
  kiboko_magento_connector.repository.cached.catalog_attribute:
    class: '%kiboko_magento_connector.repository.cached.catalog_attribute.class%'
    arguments:
      - '@kiboko_magento_connector.repository.doctrine.catalog_attribute'
```

## Persisting data

There is currently 2 ways of importing data : the standard and portable *DML* way, using `INSERT` and `UPDATE` queries. The second is *MySQL* specific and is an order of magnitude faster when you need to do large imports.

Concerning product attributes, data are stored in 2 tables. To address this you need 2 persisters : one for the standard attribute values and one for catalog specific attribute options. To keep things simple, a facade object will keep hard things hidden.

### Portable DML

#### PHP initialization

```php
<?php

/** @var \Doctrine\DBAL\Connection $connection */

use Kiboko\Component\MagentoORM\Persister\StandardDml\Attribute\StandardAttributePersister;
use Kiboko\Component\MagentoORM\Persister\StandardDml\V2_0ce\Attribute\CatalogAttributeExtensionPersister;
use Kiboko\Component\MagentoORM\Persister\CatalogAttributePersister;
use Kiboko\Component\MagentoORM\QueryBuilder\V2_0ce\Doctrine\ProductAttributeQueryBuilder;

$standardAttributePersister = new StandardAttributePersister(
    $connection,
    ProductAttributeQueryBuilder::getDefaultTable()
);

$catalogAttributeExtensionsPersister = new CatalogAttributeExtensionPersister(
    $connection,
    ProductAttributeQueryBuilder::getDefaultTable()
);

$cataogAttributePersister = new CatalogAttributePersister(
    $standardAttributePersister,
    $catalogAttributeExtensionsPersister
);
```

#### YAML initialization

```yaml
parameters:
  kiboko_magento_connector.persister.standard_dml.attribute.standard.class: Kiboko\Component\MagentoORM\Persister\StandardDml\Attribute\StandardAttributePersister
  kiboko_magento_connector.persister.standard_dml.attribute.catalog_extras.class:  Kiboko\Component\MagentoORM\Persister\StandardDml\V2_0ce\Attribute\CatalogAttributeExtensionPersister
  kiboko_magento_connector.persister.standard_dml.attribute.catalog.class:  Kiboko\Component\MagentoORM\Persister\CatalogAttributePersister
  
  kiboko_magento_connector.backend.attribute.standard.table:       'eav_attribute'
  kiboko_magento_connector.backend.attribute.catalog_extras.table: 'catalog_eav_attribute'
  
services:
  kiboko_magento_connector.persister.standard_dml.attribute.standard:
    class: '%kiboko_magento_connector.persister.standard_dml.attribute.standard.class%'
    arguments:
      - '@doctrine.dbal.magento_connection'
      - '%kiboko_magento_connector.backend.attribute.standard.table%'

  kiboko_magento_connector.persister.standard_dml.attribute.catalog_extras:
    class: '%kiboko_magento_connector.persister.standard_dml.attribute.catalog_extras.class%'
    arguments:
      - '@doctrine.dbal.magento_connection'
      - '%kiboko_magento_connector.backend.attribute.catalog_extras.table%'

  kiboko_magento_connector.persister.standard_dml.attribute.catalog:
    class: '%kiboko_magento_connector.persister.standard_dml.attribute.catalog.class%'
    arguments:
      - '@kiboko_magento_connector.persister.standard_dml.attribute.standard'
      - '@kiboko_magento_connector.persister.standard_dml.attribute.catalog_extras'
```

#### MySQL specific, CSV direct importer

The CSV direct importer requires some more configuration, as long as data can be written on a remote server, transferred either directly by MySQL or by another tool.

`@TODO`

### Using the persister

```php
<?php
/** @var \Kiboko\Component\MagentoORM\Model\V2_0ce\CatalogAttributeInterface[] $data */
/** @var Kiboko\Component\MagentoORM\Persister\CatalogAttributePersister $cataogAttributePersister */

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

/** @var \Doctrine\DBAL\Connection $connection */
/** @var \Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\ProductAttributeQueryBuilderInterface $queryBuilder */

use Kiboko\Component\MagentoORM\Deleter\Doctrine\AttributeDeleter;

new AttributeDeleter(
    $connection,
    $queryBuilder
);
```

### YAML initialization

```yaml
parameters:
  kiboko_magento_connector.deleter.attribute.class: Kiboko\Component\MagentoORM\Deleter\Doctrine\AttributeDeleter
sevices:
  kiboko_magento_connector.deleter.attribute:
    class: '%kiboko_magento_connector.deleter.attribute.class%'
    arguments:
      - '@doctrine.dbal.magento_connection'
      - '@kiboko_magento_connector.query_builder.attribute'
```

### Using the deleter

Aslike the *Repository*, the *Deleter* has explicitly-named methods, for now 4 exist. You will need to know attribute codes or ID to delete data.

```php
<?php

/** @var Kiboko\Component\MagentoORM\Deleter\AttributeDeleterInterface $deleter */

$deleter->deleteOneById(72);

$deleter->deleteAllById([72, 56, 234]);

$deleter->deleteOneByCode('shoe_size');

$deleter->deleteAllByCode(['shoe_size', 'heel_height']);
```
