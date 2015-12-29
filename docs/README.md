# Documentation

## Initializing the `ProductAttributeQueryBuilder`

This object creates Doctrine DBAL `QueryBuilder` objects for various usages, including repositories.

```php
<?php

use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilder;

$queryBuilder = new ProductAttributeQueryBuilder(
    $connection,
    'eav_attribute',
    'catalog_eav_attribute',
    'catalog_product_super_attribute',
    'eav_attribute_set',
    [
        'attribute_id',
        'attribute_code',
        'attribute_model',
        'backend_model',
        'backend_type',
        'backend_table',
        'frontend_model',
        'frontend_input',
        'frontend_label',
        'frontend_class',
        'source_model',
        'is_required',
        'is_user_defined',
        'default_value',
        'is_unique',
    ],
    [
        'frontend_input_renderer',
        'is_global',
        'is_visible',
        'is_searchable',
        'is_filterable',
        'is_comparable',
        'is_visible_on_front',
        'is_html_allowed_on_front',
        'is_used_for_price_rules',
        'is_filterable_in_search',
        'used_in_product_listing',
        'used_for_sort_by',
        'is_configurable',
        'apply_to',
        'is_visible_in_advanced_search',
        'position',
        'is_wysiwyg_enabled',
        'is_used_for_promo_rules',
    ]
);
```

## Loading an attribute from the `ProductAttributeRepository`

The `ProductAttributeRepository` makes easier the attribute object fetching.

```php
<?php

use Luni\Component\MagentoDriver\Repository\Doctrine\ProductAttributeRepository;

$productAttributeRepository = new ProductAttributeRepository(
    $connection,
    $queryBuilder
);

$skuAttribute = $productAttributeRepository->findOneByCode('sku');

$attributeList = $productAttributeRepository->findAllByCode(['sku', 'image', 'name']);

$attributeList = $productAttributeRepository->findAllByid([74, 71, 85]);
```

## Initialize the `DatetimeAttributeBackend` objects

This `DatetimeAttributeBackend` is used to store attribute values of type `datetime`.

```php
<?php

use League\Flysystem\File;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Luni\Component\MagentoDriver\Backend\Attribute\DatetimeAttributeBackend;

$localFs = new Filesystem(new Local(__DIR__));

$backendFields = [
    'value_id',
    'entity_type_id',
    'attribute_id',
    'store_id',
    'entity_id',
    'value',
];

$datetimeTemporaryWriter = new StandardTemporaryWriter(new File($localFs, 'tmp/attribute/datetime.csv'), ';', '"', '"');
$datetimeDatabaseWriter = new LocalDataInfileDatabaseWriter(new File($localFs, 'tmp/attribute/datetime.csv'), $connection, ';', '"', '"');
$datetimeBackend = new DatetimeAttributeBackend($datetimeTemporaryWriter, $datetimeDatabaseWriter, 'catalog_product_entity_datetime', $backendFields);

$releaseDateAttribute = $productAttributeRepository->findOneByCode('release_date');

$datetimeBackend->initialize();
/** @var \Luni\Component\MagentoDriver\Entity\ProductInterface $product */
foreach ($productList as $product) {
    $datetimeBackend->persist($product, $product->getValueFor($releaseDateAttribute));
}
$datetimeBackend->flush();
```

## Initialize the `DecimalAttributeBackend` objects

This `DecimalAttributeBackend` is used to store attribute values of type `decimal`.

```php
<?php

use League\Flysystem\File;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Luni\Component\MagentoDriver\Backend\Attribute\DecimalAttributeBackend;

$localFs = new Filesystem(new Local(__DIR__));

$backendFields = [
    'value_id',
    'entity_type_id',
    'attribute_id',
    'store_id',
    'entity_id',
    'value',
];

$decimalTemporaryWriter = new StandardTemporaryWriter(new File($localFs, 'tmp/attribute/decimal.csv'), ';', '"', '"');
$decimalDatabaseWriter = new LocalDataInfileDatabaseWriter(new File($localFs, 'tmp/attribute/decimal.csv'), $connection, ';', '"', '"');
$decimalBackend = new DecimalAttributeBackend($decimalTemporaryWriter, $decimalDatabaseWriter, 'catalog_product_entity_decimal', $backendFields);

$specialPriceAttribute = $productAttributeRepository->findOneByCode('special_price');

$decimalBackend->initialize();
/** @var \Luni\Component\MagentoDriver\Entity\ProductInterface $product */
foreach ($productList as $product) {
    $decimalBackend->persist($product, $product->getValueFor($specialPriceAttribute));
}
$decimalBackend->flush();
```

## Initialize the `IntegerAttributeBackend` objects

This `IntegerAttributeBackend` is used to store attribute values of type `int`.

```php
<?php

use League\Flysystem\File;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Luni\Component\MagentoDriver\Backend\Attribute\IntegerAttributeBackend;

$localFs = new Filesystem(new Local(__DIR__));

$backendFields = [
    'value_id',
    'entity_type_id',
    'attribute_id',
    'store_id',
    'entity_id',
    'value',
];

$integerTemporaryWriter = new StandardTemporaryWriter(new File($localFs, 'tmp/attribute/integer.csv'), ';', '"', '"');
$integerDatabaseWriter = new LocalDataInfileDatabaseWriter(new File($localFs, 'tmp/attribute/integer.csv'), $connection, ';', '"', '"');
$integerBackend = new IntegerAttributeBackend($integerTemporaryWriter, $integerDatabaseWriter, 'catalog_product_entity_integer', $backendFields);

$isActiveAttribute = $productAttributeRepository->findOneByCode('is_active');

$integerBackend->initialize();
/** @var \Luni\Component\MagentoDriver\Entity\ProductInterface $product */
foreach ($productList as $product) {
    $integerBackend->persist($product, $product->getValueFor($isActiveAttribute));
}
$integerBackend->flush();
```

## Initialize the `TextAttributeBackend` objects

This `TextAttributeBackend` is used to store attribute values of type `text`.

```php
<?php

use League\Flysystem\File;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Luni\Component\MagentoDriver\Backend\Attribute\TextAttributeBackend;

$localFs = new Filesystem(new Local(__DIR__));

$backendFields = [
    'value_id',
    'entity_type_id',
    'attribute_id',
    'store_id',
    'entity_id',
    'value',
];

$textTemporaryWriter = new StandardTemporaryWriter(new File($localFs, 'tmp/attribute/text.csv'), ';', '"', '"');
$textDatabaseWriter = new LocalDataInfileDatabaseWriter(new File($localFs, 'tmp/attribute/text.csv'), $connection, ';', '"', '"');
$textBackend = new TextAttributeBackend($textTemporaryWriter, $textDatabaseWriter, 'catalog_product_entity_text', $backendFields);

$descriptionAttribute = $productAttributeRepository->findOneByCode('description');

$textBackend->initialize();
/** @var \Luni\Component\MagentoDriver\Entity\ProductInterface $product */
foreach ($productList as $product) {
    $textBackend->persist($product, $product->getValueFor($descriptionAttribute));
}
$textBackend->flush();
```

## Initialize the `VarcharAttributeBackend` objects

This `VarcharAttributeBackend` is used to store attribute values of type `varchar`.

```php
<?php

use League\Flysystem\File;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Luni\Component\MagentoDriver\Backend\Attribute\VarcharAttributeBackend;

$localFs = new Filesystem(new Local(__DIR__));

$backendFields = [
    'value_id',
    'entity_type_id',
    'attribute_id',
    'store_id',
    'entity_id',
    'value',
];

$varcharTemporaryWriter = new StandardTemporaryWriter(new File($localFs, 'tmp/attribute/varchar.csv'), ';', '"', '"');
$varcharDatabaseWriter = new LocalDataInfileDatabaseWriter(new File($localFs, 'tmp/attribute/varchar.csv'), $connection, ';', '"', '"');
$varcharBackend = new VarcharAttributeBackend($varcharTemporaryWriter, $varcharDatabaseWriter, 'catalog_product_entity_varchar', $backendFields);

$nameAttribute = $productAttributeRepository->findOneByCode('name');

$varcharBackend->initialize();
/** @var \Luni\Component\MagentoDriver\Entity\ProductInterface $product */
foreach ($productList as $product) {
    $varcharBackend->persist($product, $product->getValueFor($nameAttribute));
}
$varcharBackend->flush();
```

## Initialize the `StaticAttributeBackend` objects

This `StaticAttributeBackend` is used to store attribute values of type `static`.

It is a placeholder and does nothing on the database.

```php
<?php

use League\Flysystem\File;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Luni\Component\MagentoDriver\Backend\Attribute\StaticAttributeBackend;

$staticBackend = new StaticAttributeBackend();

$releaseDateAttribute = $productAttributeRepository->findOneByCode('release_date');

$staticBackend->initialize();
/** @var \Luni\Component\MagentoDriver\Entity\ProductInterface $product */
foreach ($productList as $product) {
    $staticBackend->persist($product, $product->getValueFor($releaseDateAttribute));
}
$staticBackend->flush();
```

## Initialize the `AttributeBackendBroker`

Once all your backends have been initialized, you can use the `AttributeBackendBroker` to find the best backend.

```php
<?php

use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\Broker\AttributeBackendBroker;

$backendBroker = new AttributeBackendBroker();
$backendBroker->addBackend($datetimeBackend, function(AttributeInterface $attribute) {
    return $attribute->getBackendType() === 'datetime';
});
$backendBroker->addBackend($decimalBackend, function(AttributeInterface $attribute) {
    return $attribute->getBackendType() === 'decimal';
});
$backendBroker->addBackend($integerBackend, function(AttributeInterface $attribute) {
    return $attribute->getBackendType() === 'int';
});
$backendBroker->addBackend($textBackend, function(AttributeInterface $attribute) {
    return $attribute->getBackendType() === 'text';
});
$backendBroker->addBackend($varcharBackend, function(AttributeInterface $attribute) {
    return $attribute->getBackendType() === 'varchar';
});
$backendBroker->addBackend($staticBackend, function(AttributeInterface $attribute) {
    return $attribute->getBackendType() === 'static';
});

$releaseDateAttribute = $productAttributeRepository->findOneByCode('release_date');
$bestBackend = $backendBroker->find($releaseDateAttribute);

$bestBackend->initialize();
/** @var \Luni\Component\MagentoDriver\Entity\ProductInterface $product */
foreach ($productList as $product) {
    $bestBackend->persist($product, $product->getValueFor($releaseDateAttribute));
}
$bestBackend->flush();
```