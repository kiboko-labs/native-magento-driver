# Product attribute values

You will need here to create an object by backend table, which include in a standard Magento installation:

* `decimal` for fixed-precision numbers
* `datetime` for date and time values
* `integer` for integer numbers
* `text` for text values
* `varchar` for short text values (255 chars max)  

It may happen on specific cases that another table(s) has been generated and handle specific types.

You will be able to add a new backend, by instancing a new `ProductAttributeValueQueryBuilder`, changing the 2nd constructor argument with the correct table name.

## Initializing the backend query builders

This object creates Doctrine DBAL `QueryBuilder` objects for entity type data fetching. It is used by repositories.

### PHP initialization

```php
<?php

/** @var \Doctrine\DBAL\Connection $connection */

use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeValueQueryBuilder;

$productAttributeDecimalQueryBuilder = new ProductAttributeValueQueryBuilder(
    $connection,
    ProductAttributeValueQueryBuilder::getDefaultTable('decimal'),
    ProductAttributeValueQueryBuilder::getDefaultVariantAxisTable()
);
$productAttributeDatetimeQueryBuilder = new ProductAttributeValueQueryBuilder(
    $connection,
    ProductAttributeValueQueryBuilder::getDefaultTable('datetime'),
    ProductAttributeValueQueryBuilder::getDefaultVariantAxisTable()
);
$productAttributeIntegerQueryBuilder = new ProductAttributeValueQueryBuilder(
    $connection,
    ProductAttributeValueQueryBuilder::getDefaultTable('int'),
    ProductAttributeValueQueryBuilder::getDefaultVariantAxisTable()
);
$productAttributeTextQueryBuilder = new ProductAttributeValueQueryBuilder(
    $connection,
    ProductAttributeValueQueryBuilder::getDefaultTable('text'),
    ProductAttributeValueQueryBuilder::getDefaultVariantAxisTable()
);
$productAttributeVarcharQueryBuilder = new ProductAttributeValueQueryBuilder(
    $connection,
    ProductAttributeValueQueryBuilder::getDefaultTable('varchar'),
    ProductAttributeValueQueryBuilder::getDefaultVariantAxisTable()
);
```

### YAML initialization

```yaml
parameters:
  kiboko.magento_driver.query_builder.doctrine.product_attribute_value.class: Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeValueQueryBuilder
  
  kiboko.magento_driver.backend.product_attribute_value.datetime.table: 'catalog_product_entity_datetime'
  kiboko.magento_driver.backend.product_attribute_value.decimal.table: 'catalog_product_entity_decimal'
  kiboko.magento_driver.backend.product_attribute_value.integer.table: 'catalog_product_entity_integer'
  kiboko.magento_driver.backend.product_attribute_value.text.table: 'catalog_product_entity_text'
  kiboko.magento_driver.backend.product_attribute_value.varchar.table: 'catalog_product_entity_varchar'
  kiboko.magento_driver.backend.product_attribute_value.variant_axis.table: 'catalog_product_super_attribute'
  kiboko.magento_driver.backend.product_attribute_value.fields:
    - 'value_id'
    - 'entity_type_id'
    - 'attribute_id'
    - 'store_id'
    - 'entity_id'
    - 'value'

services:
  kiboko.magento_driver.query_builder.doctrine.product_attribute_value.datetime:
    class: '%kiboko.magento_driver.query_builder.doctrine.product_attribute_value.class%'
    arguments:
      - '@database.connection'
      - '%kiboko.magento_driver.backend.product_attribute_value.datetime.table%'
      - '%kiboko.magento_driver.backend.product_attribute_value.variant_axis.table%'
      - '%kiboko.magento_driver.backend.product_attribute_value.fields%'

  kiboko.magento_driver.query_builder.doctrine.product_attribute_value.decimal:
    class: '%kiboko.magento_driver.query_builder.doctrine.product_attribute_value.class%'
    arguments:
      - '@database.connection'
      - '%kiboko.magento_driver.backend.product_attribute_value.decimal.table%'
      - '%kiboko.magento_driver.backend.product_attribute_value.variant_axis.table%'
      - '%kiboko.magento_driver.backend.product_attribute_value.fields%'

  kiboko.magento_driver.query_builder.doctrine.product_attribute_value.integer:
    class: '%kiboko.magento_driver.query_builder.doctrine.product_attribute_value.class%'
    arguments:
      - '@database.connection'
      - '%kiboko.magento_driver.backend.product_attribute_value.integer.table%'
      - '%kiboko.magento_driver.backend.product_attribute_value.variant_axis.table%'
      - '%kiboko.magento_driver.backend.product_attribute_value.fields%'

  kiboko.magento_driver.query_builder.doctrine.product_attribute_value.text:
    class: '%kiboko.magento_driver.query_builder.doctrine.product_attribute_value.class%'
    arguments:
      - '@database.connection'
      - '%kiboko.magento_driver.backend.product_attribute_value.text.table%'
      - '%kiboko.magento_driver.backend.product_attribute_value.variant_axis.table%'
      - '%kiboko.magento_driver.backend.product_attribute_value.fields%'

  kiboko.magento_driver.query_builder.doctrine.product_attribute_value.varchar:
    class: '%kiboko.magento_driver.query_builder.doctrine.product_attribute_value.class%'
    arguments:
      - '@database.connection'
      - '%kiboko.magento_driver.backend.product_attribute_value.varchar.table%'
      - '%kiboko.magento_driver.backend.product_attribute_value.variant_axis.table%'
      - '%kiboko.magento_driver.backend.product_attribute_value.fields%'
```

## Initializing the Repository

The *Repository* objects helps you fetch data from the database. It requires a proper *QueryBuilder* to work.

Due to the fact that there is at least 5 backends, you will need to initialize 5 different repositories. To address this, the library provides a facade to simplify usage.

The repository requires an `AttributeRepositoryInterface` object, please see [proper documentation](product-attributes.md).

### PHP initialization

```php
<?php

use Kiboko\Component\MagentoDriver\Repository\Doctrine\ProductAttributeValueRepository;
use Kiboko\Component\MagentoDriver\Factory\ProductAttributeValue\DatetimeProductAttributeValueFactory;
use Kiboko\Component\MagentoDriver\Factory\ProductAttributeValue\DecimalProductAttributeValueFactory;
use Kiboko\Component\MagentoDriver\Factory\ProductAttributeValue\IntegerProductAttributeValueFactory;
use Kiboko\Component\MagentoDriver\Factory\ProductAttributeValue\TextProductAttributeValueFactory;
use Kiboko\Component\MagentoDriver\Factory\ProductAttributeValue\VarcharProductAttributeValueFactory;

$productAttributeDatetimeValueRepository = new ProductAttributeValueRepository(
    $connection,
    $productAttributeDatetimeQueryBuilder,
    $attributeRepository,
    new DatetimeProductAttributeValueFactory();
);

$productAttributeDecimalValueRepository = new ProductAttributeValueRepository(
    $connection,
    $productAttributeDecimalQueryBuilder,
    $attributeRepository,
    new DecimalProductAttributeValueFactory();
);

$productAttributeIntegerValueRepository = new ProductAttributeValueRepository(
    $connection,
    $productAttributeIntegerQueryBuilder,
    $attributeRepository,
    new IntegerProductAttributeValueFactory();
);

$productAttributeTextValueRepository = new ProductAttributeValueRepository(
    $connection,
    $productAttributeTextQueryBuilder,
    $attributeRepository,
    new TextProductAttributeValueFactory();
);

$productAttributeVarcharValueRepository = new ProductAttributeValueRepository(
    $connection,
    $productAttributeVarcharQueryBuilder,
    $attributeRepository,
    new VarcharProductAttributeValueFactory();
);
```

### YAML initialization

```yaml
parameters:
  kiboko.magento_driver.factory.catalog_attribute_value.datetime.class: Kiboko\Component\MagentoDriver\Factory\ProductAttributeValue\DatetimeProductAttributeValueFactory
  kiboko.magento_driver.factory.catalog_attribute_value.decimal.class:  Kiboko\Component\MagentoDriver\Factory\ProductAttributeValue\DecimalProductAttributeValueFactory
  kiboko.magento_driver.factory.catalog_attribute_value.integer.class:  Kiboko\Component\MagentoDriver\Factory\ProductAttributeValue\IntegerProductAttributeValueFactory
  kiboko.magento_driver.factory.catalog_attribute_value.text.class:     Kiboko\Component\MagentoDriver\Factory\ProductAttributeValue\TextProductAttributeValueFactory
  kiboko.magento_driver.factory.catalog_attribute_value.varchar.class:  Kiboko\Component\MagentoDriver\Factory\ProductAttributeValue\VarcharProductAttributeValueFactory
  
  kiboko.magento_driver.repository.doctrine.product_attribute_value.class: Kiboko\Component\MagentoDriver\Repository\Doctrine\ProductAttributeValueRepository

services:
  kiboko.magento_driver.factory.catalog_attribute_value.datetime:
    class: '%kiboko.magento_driver.factory.catalog_attribute_value.datetime%'
    
  kiboko.magento_driver.factory.catalog_attribute_value.decimal:
    class: '%kiboko.magento_driver.factory.catalog_attribute_value.decimal%'
    
  kiboko.magento_driver.factory.catalog_attribute_value.integer:
    class: '%kiboko.magento_driver.factory.catalog_attribute_value.integer%'
    
  kiboko.magento_driver.factory.catalog_attribute_value.text:
    class: '%kiboko.magento_driver.factory.catalog_attribute_value.text%'
    
  kiboko.magento_driver.factory.catalog_attribute_value.varchar:
    class: '%kiboko.magento_driver.factory.catalog_attribute_value.varchar%'
    
  kiboko.magento_driver.repository.doctrine.product_attribute_value.datetime:
    class: '%kiboko.magento_driver.repository.doctrine.product_attribute_value.class%'
    arguments:
      - '@database.connection'
      - '@kiboko.magento_driver.query_builder.doctrine.product_attribute_value.datetime'
      - '@kiboko.magento_driver.repository.doctrine.catalog_attribute'
      - '@kiboko.magento_driver.factory.catalog_attribute_value.datetime'
    
  kiboko.magento_driver.repository.doctrine.product_attribute_value.decimal:
    class: '%kiboko.magento_driver.repository.doctrine.product_attribute_value.class%'
    arguments:
      - '@database.connection'
      - '@kiboko.magento_driver.query_builder.doctrine.product_attribute_value.decimal'
      - '@kiboko.magento_driver.repository.doctrine.catalog_attribute'
      - '@kiboko.magento_driver.factory.catalog_attribute_value.decimal'
    
  kiboko.magento_driver.repository.doctrine.product_attribute_value.integer:
    class: '%kiboko.magento_driver.repository.doctrine.product_attribute_value.class%'
    arguments:
      - '@database.connection'
      - '@kiboko.magento_driver.query_builder.doctrine.product_attribute_value.integer'
      - '@kiboko.magento_driver.repository.doctrine.catalog_attribute'
      - '@kiboko.magento_driver.factory.catalog_attribute_value.integer'
    
  kiboko.magento_driver.repository.doctrine.product_attribute_value.text:
    class: '%kiboko.magento_driver.repository.doctrine.product_attribute_value.class%'
    arguments:
      - '@database.connection'
      - '@kiboko.magento_driver.query_builder.doctrine.product_attribute_value.text'
      - '@kiboko.magento_driver.repository.doctrine.catalog_attribute'
      - '@kiboko.magento_driver.factory.catalog_attribute_value.text'
    
  kiboko.magento_driver.repository.doctrine.product_attribute_value.varchar:
    class: '%kiboko.magento_driver.repository.doctrine.product_attribute_value.class%'
    arguments:
      - '@database.connection'
      - '@kiboko.magento_driver.query_builder.doctrine.product_attribute_value.varchar'
      - '@kiboko.magento_driver.repository.doctrine.catalog_attribute'
      - '@kiboko.magento_driver.factory.catalog_attribute_value.varchar'
```

## Initializing the backend broker and facade

Due to the fact that there could be a lot of different backends, the library provides an abstraction layer to hide from outer parts the types and the number of backends.

### PHP initialization

```php
<?php

use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Broker\AttributeBackendBroker;
use Kiboko\Component\MagentoDriver\Matcher\AttributeType\BackendTypeAttributeValueMatcher;

$backendBroker = new AttributeBackendBroker();
$backendBroker->addBackend($productAttributeDatetimeQueryBuilder, new BackendTypeAttributeValueMatcher('int'));
$backendBroker->addBackend($productAttributeDecimalQueryBuilder, new BackendTypeAttributeValueMatcher('datetime'));
$backendBroker->addBackend($productAttributeIntegerQueryBuilder, new BackendTypeAttributeValueMatcher('decimal'));
$backendBroker->addBackend($productAttributeTextQueryBuilder, new BackendTypeAttributeValueMatcher('text'));
$backendBroker->addBackend($productAttributeVarcharQueryBuilder, new BackendTypeAttributeValueMatcher('varchar');;

$backendBroker->addBackend($productAttributeDecimalQueryBuilder, new BackendTypeAttributeValueMatcher('static'));

```
