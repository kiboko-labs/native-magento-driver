# Entities

## Entity types (table `eav_entity_type`)

* [ ] reader

## Entity configuration by store (table `eav_entity_store`)

* [ ] reader
* [ ] persister
* [ ] deleter

# Families

## Global families data (table `eav_attribute_set`)

* [x] reader [Interface](src/MagentoDriver/Repository/FamilyRepositoryInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Repository/Doctrine/FamilyRepository.php)
* [x] persister [Interface](src/MagentoDriver/Persister/FamilyPersisterInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Persister/Direct/Family/StandardFamilyPersister.php)
  * [Doctrine DBAL + FILE implementation](src/MagentoDriver/Persister/FlatFile/Family/StandardFamilyPersister.php)
* [x] deleter [Interface](src/MagentoDriver/Deleter/FamilyDeleterInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Deleter/Doctrine/FamilyDeleter.php)

# Attributes

## Global attributes data (table `eav_attribute`)

* [x] reader [Interface](src/MagentoDriver/Repository/AttributeRepositoryInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Repository/Doctrine/CatalogAttributeRepository.php)
* [x] persister [Interface](src/MagentoDriver/Persister/AttributePersisterInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Persister/Direct/Attribute/StandardAttributePersister.php)
  * [Doctrine DBAL + FILE implementation](src/MagentoDriver/Persister/FlatFile/Attribute/StandardAttributePersister.php)
* [ ] deleter

## Attribute groups (table `eav_attribute_group`)

* [ ] reader
* [ ] persister
* [ ] deleter

## Attribute labels (table `eav_attribute_label`)

* [ ] reader
* [ ] persister
* [ ] deleter

## Attribute options (table `eav_attribute_option`)

* [ ] reader
* [ ] persister
* [ ] deleter

## Attribute option values (table `eav_attribute_option_value`)

* [ ] reader
* [ ] persister
* [ ] deleter

## Attribute to entity linking (table `eav_entity_attribute`)

* [ ] reader
* [ ] persister
* [ ] deleter

## Catalog Attributes extensions (table `catalog_eav_attribute`)

* [x] reader [Interface](src/MagentoDriver/Repository/AttributeRepositoryInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Repository/Doctrine/CatalogAttributeRepository.php)
* [x] persister [Interface](src/MagentoDriver/Repository/CatalogAttributeExtensionPersisterInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Persister/Direct/Attribute/CatalogAttributeExtensionPersister.php)
  * [Doctrine DBAL + FILE implementation](src/MagentoDriver/Persister/FlatFile/Attribute/CatalogAttributeExtensionPersister.php)
* [ ] deleter

# Products

## Product entities (table `catalog_product_entity`)

* [x] reader [Interface](src/MagentoDriver/Repository/ProductRepositoryInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Repository/Doctrine/ProductRepository.php)
* [x] persister [Interface](src/MagentoDriver/Persister/ProductPersisterInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Persister/Direct/Product/SimpleProductPersister.php.php)
  * [Doctrine DBAL + FILE implementation](src/MagentoDriver/Persister/FlatFile/Product/SimpleProductPersister.php.php)
* [x] delete [Interface](src/MagentoDriver/Deleter/ProductDeleterInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Deleter/Doctrine/ProductDeleter.php)

## Datetime values (table `catalog_product_entity_datetime`)

* [x] reader [Interface](src/MagentoDriver/Repository/ProductAttributeValueRepositoryBackendInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Repository/Doctrine/ProductAttributeValueRepository.php)
* [x] persister [Interface](src/MagentoDriver/Persister/AttributeValuePersisterInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Persister/Direct/AttributeValue/DecimalAttributeValuePersister.php)
  * [Doctrine DBAL + FILE implementation](src/MagentoDriver/Persister/FlatFile/AttributeValue/DatetimeAttributeValuePersister.php)
* [ ] deleter

## Decimal values (table `catalog_product_entity_decimal`)

* [x] reader [Interface](src/MagentoDriver/Repository/ProductAttributeValueRepositoryBackendInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Repository/Doctrine/ProductAttributeValueRepository.php)
* [x] persister [Interface](src/MagentoDriver/Persister/AttributeValuePersisterInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Persister/Direct/AttributeValue/DecimalAttributeValuePersister.php)
  * [Doctrine DBAL + FILE implementation](src/MagentoDriver/Persister/FlatFile/AttributeValue/DecimalAttributeValuePersister.php)
* [ ] deleter

## Integer values (table `catalog_product_entity_int`)

* [x] reader [Interface](src/MagentoDriver/Repository/ProductAttributeValueRepositoryBackendInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Repository/Doctrine/ProductAttributeValueRepository.php)
* [x] persister [Interface](src/MagentoDriver/Persister/AttributeValuePersisterInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Persister/Direct/AttributeValue/IntegerAttributeValuePersister.php)
  * [Doctrine DBAL + FILE implementation](src/MagentoDriver/Persister/FlatFile/AttributeValue/IntegerAttributeValuePersister.php)
* [ ] deleter

## Text values (table `catalog_product_entity_text`)

* [x] reader [Interface](src/MagentoDriver/Repository/ProductAttributeValueRepositoryBackendInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Repository/Doctrine/ProductAttributeValueRepository.php)
* [x] persister [Interface](src/MagentoDriver/Persister/AttributeValuePersisterInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Persister/Direct/AttributeValue/TextAttributeValuePersister.php)
  * [Doctrine DBAL + FILE implementation](src/MagentoDriver/Persister/FlatFile/AttributeValue/TextAttributeValuePersister.php)
* [ ] deleter

## Varchar values (table `catalog_product_entity_varchar`)

* [x] reader [Interface](src/MagentoDriver/Repository/ProductAttributeValueRepositoryBackendInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Repository/Doctrine/ProductAttributeValueRepository.php)
* [x] persister [Interface](src/MagentoDriver/Persister/AttributeValuePersisterInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Persister/Direct/AttributeValue/VarcharAttributeValuePersister.php)
  * [Doctrine DBAL + FILE implementation](src/MagentoDriver/Persister/FlatFile/AttributeValue/VarcharAttributeValuePersister.php)
* [ ] deleter

## Super attribute relations (table `catalog_product_entity_super_attribute`)

* [ ] read
* [x] persister [Interface](src/MagentoDriver/Persister/SuperAttributePersisterInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Persister/Direct/SuperAttribute/ProductSuperAttributePersister.php)
  * [Doctrine DBAL + FILE implementation](src/MagentoDriver/Persister/FlatFile/SuperAttribute/ProductSuperAttributePersister.php)
* [ ] deleter

## Super link relations (table `catalog_product_entity_super_link`)

* [ ] read
* [x] persister [Interface](src/MagentoDriver/Persister/SuperLinkPersisterInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Persister/Direct/SuperLink/ProductSuperLinkPersister.php)
  * [Doctrine DBAL + FILE implementation](src/MagentoDriver/Persister/FlatFile/SuperLink/ProductSuperLinkPersister.php)
* [ ] deleter

## Super link attribute label (table `catalog_product_entity_super_attribute_label`)

* [ ] read
* [ ] persister
* [ ] deleter

## Super link attribute pricing (table `catalog_product_entity_super_attribute_pricing`)

* [ ] read
* [ ] persister
* [ ] deleter

## Tier prices (table `catalog_product_entity_tier_price`)

* [ ] read
* [ ] persister
* [ ] deleter

## Product price index (table `catalog_product_entity_group_price`)

* [ ] read
* [ ] persister
* [ ] deleter

## Product link types (table `catalog_product_link_type`)

* [ ] read
* [ ] persister
* [ ] deleter

## Product linking (table `catalog_product_link`)

* [ ] read
* [ ] persister
* [ ] deleter

## Product linking attribute setup (table `catalog_product_link_attribute`)

* [ ] read
* [ ] persister
* [ ] deleter

## Product linking attribute data - decimal (table `catalog_product_link_attribute_decimal`)

* [ ] read
* [ ] persister
* [ ] deleter

## Product linking attribute data - integer (table `catalog_product_link_attribute_int`)

* [ ] read
* [ ] persister
* [ ] deleter

## Product linking attribute data - varchar (table `catalog_product_link_attribute_varchar`)

* [ ] read
* [ ] persister
* [ ] deleter

# Categories

## Category entities (table `catalog_category_entity`)

* [ ] reader
* [x] persister [Interface](src/MagentoDriver/Persister/CategoryPersisterInterface.php)
* [ ] deleter

## Datetime values (table `catalog_category_entity_datetime`)

* [ ] reader
* [x] persister [Interface](src/MagentoDriver/Persister/AttributeValuePersisterInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Persister/Direct/AttributeValue/DecimalAttributeValuePersister.php)
  * [Doctrine DBAL + FILE implementation](src/MagentoDriver/Persister/FlatFile/AttributeValue/DatetimeAttributeValuePersister.php)
* [ ] deleter

## Decimal values (table `catalog_category_entity_decimal`)

* [ ] reader
* [x] persister [Interface](src/MagentoDriver/Persister/AttributeValuePersisterInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Persister/Direct/AttributeValue/DecimalAttributeValuePersister.php)
  * [Doctrine DBAL + FILE implementation](src/MagentoDriver/Persister/FlatFile/AttributeValue/DecimalAttributeValuePersister.php)
* [ ] deleter

## Integer values (table `catalog_category_entity_int`)

* [ ] reader
* [x] persister [Interface](src/MagentoDriver/Persister/AttributeValuePersisterInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Persister/Direct/AttributeValue/IntegerAttributeValuePersister.php)
  * [Doctrine DBAL + FILE implementation](src/MagentoDriver/Persister/FlatFile/AttributeValue/IntegerAttributeValuePersister.php)
* [ ] deleter

## Text values (table `catalog_category_entity_text`)

* [ ] reader
* [x] persister [Interface](src/MagentoDriver/Persister/AttributeValuePersisterInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Persister/Direct/AttributeValue/TextAttributeValuePersister.php)
  * [Doctrine DBAL + FILE implementation](src/MagentoDriver/Persister/FlatFile/AttributeValue/TextAttributeValuePersister.php)
* [ ] deleter

## Varchar values (table `catalog_category_entity_varchar`)

* [ ] reader
* [x] persister [Interface](src/MagentoDriver/Persister/AttributeValuePersisterInterface.php)
  * [Doctrine DBAL implementation](src/MagentoDriver/Persister/Direct/AttributeValue/VarcharAttributeValuePersister.php)
  * [Doctrine DBAL + FILE implementation](src/MagentoDriver/Persister/FlatFile/AttributeValue/VarcharAttributeValuePersister.php)
* [ ] deleter

## Category product list (table `catalog_category_product`)

* [ ] reader
* [ ] persister
* [ ] deleter

## Category product list index (table `catalog_category_product_index`)

* [ ] persister

# Media gallery

## Media assets (table `catalog_product_entity_gallery`)

* [ ] reader
* [ ] persister
* [ ] deleter

## Media attributes (table `catalog_product_entity_media_gallery`)

* [ ] reader
* [ ] persister
* [ ] deleter

## Media locales (table `catalog_product_entity_media_gallery_value`)

* [ ] reader
* [ ] persister
* [ ] deleter

# Inventory

## Product inventories

* [ ] reader
* [ ] persister
* [ ] deleter

# Indexes

* [ ] Index triggering

# Mapping

* [ ] Family mapping
* [ ] Attribute mapping
* [ ] Attribute value option mapping