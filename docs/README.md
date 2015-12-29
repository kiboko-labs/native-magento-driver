# Documentation

## Initialize the `AttributeBackend` objects

```php
<?php

use Luni\Component\MagentoDriver\AttributeBackend\DatetimeAttributeBackend;
use Luni\Component\MagentoDriver\AttributeBackend\DecimalAttributeBackend;
use Luni\Component\MagentoDriver\AttributeBackend\IntegerAttributeBackend;
use Luni\Component\MagentoDriver\AttributeBackend\TextAttributeBackend;
use Luni\Component\MagentoDriver\AttributeBackend\VarcharAttributeBackend;

$localFs = new \League\Flysystem\Filesystem(new \League\Flysystem\Adapter\Local(__DIR__));

$datetimeBackend = new DatetimeAttributeBackend($connection, 'catalog_product_entity_datetime', $localFs);
$decimalBackend = new DecimalAttributeBackend($connection, 'catalog_product_entity_decimal', $localFs);
$integerBackend = new IntegerAttributeBackend($connection, 'catalog_product_entity_int', $localFs);
$textBackend = new TextAttributeBackend($connection, 'catalog_product_entity_text', $localFs);
$varcharBackend = new VarcharAttributeBackend($connection, 'catalog_product_entity_varchar', $localFs);
```

## Initialize the `AttributeBackend` broker

```php
<?php

use Luni\Component\MagentoDriver\Broker\AttributeBackendBroker;

$backendBroker = new AttributeBackendBroker();
$backendBroker->addBackend($datetimeBackend, function($attributeId, $attributeCode, $options) {
    return isset($options['backend_type']) && $options['backend_type'] === 'datetime';
});
$backendBroker->addBackend($decimalBackend, function($attributeId, $attributeCode, $options) {
    return isset($options['backend_type']) && $options['backend_type'] === 'decimal';
});
$backendBroker->addBackend($integerBackend, function($attributeId, $attributeCode, $options) {
    return isset($options['backend_type']) && $options['backend_type'] === 'int';
});
$backendBroker->addBackend($textBackend, function($attributeId, $attributeCode, $options) {
    return isset($options['backend_type']) && $options['backend_type'] === 'text';
});
$backendBroker->addBackend($varcharBackend, function($attributeId, $attributeCode, $options) {
    return (isset($options['backend_type']) && $options['backend_type'] === 'varchar') ||
        $attributeCode === 'sku'
    ;
});
```

## Initializing the `ProductAttributeQueryBuilder`

```php
<?php

$queryBuilder = new \Luni\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilder(
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

## Loading an attribute from `Repository`

```php
<?php

$repo = new Repository\Doctrine\ProductAttributeRepository(
    $connection,
    $queryBuilder,
    $backendBroker
);

$skuAttribute = $repo->findOneByCode('sku');

$attributeList = $repo->findAllByCode(['sku', 'image', 'name']);

$attributeList = $repo->findAllByid([74, 71, 85]);
```