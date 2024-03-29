# Core

## Stores (table `core_store` / `store`)

* [x] repository [Interface](src/MagentoORM/Repository/StoreRepositoryInterface.php)
  * [Standard DML implementation](src/MagentoORM/Repository/Doctrine/StoreRepository.php)


## Websites (table `core_website` / `website`)

* [ ] repository

# Entities

## Entity types (table `eav_entity_type`)

* [x] repository [Interface](src/MagentoORM/Repository/EntityTypeRepositoryInterface.php)
  * [Standard DML implementation](src/MagentoORM/Repository/Doctrine/EntityTypeRepository.php) ([PHPUnit](src/MagentoORM/unit/Repository/Doctrine/EntityTypeRepositoryTest.php))

## Entity configuration by store (table `eav_entity_store`)

* [x] repository [Interface](src/MagentoORM/Repository/EntityStoreRepositoryInterface.php)
  * [Standard DML implementation](src/MagentoORM/Repository/Doctrine/EntityStoreRepository.php) ([PHPUnit](src/MagentoORM/unit/Repository/Doctrine/EntityStoreRepositoryTest.php))
* [x] persister [Interface](src/MagentoORM/Persister/EntityStorePersisterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Persister/StandardDML/Entity/StandardEntityStorePersister.php) ([PHPUnit for 1.9CE/1.14EE](src/MagentoORM/unit/Persister/V1_9ce/StandardDML/Entity/EntityStorePersisterTest.php), [PHPUnit for 2.0+ CE/EE](src/MagentoORM/unit/Persister/V2_0ce/StandardDML/Entity/EntityStorePersisterTest.php))
  * [MySQL-specific flat file implementation](src/MagentoORM/Persister/FlatFile/Entity/StandardEntityStorePersister.php)
* [x] deleter [Interface](src/MagentoORM/Deleter/EntityStoreDeleterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Deleter/Doctrine/EntityStoreDeleter.php) ([PHPUnit for 1.9CE/1.14EE](src/MagentoORM/unit/Deleter/V1_9ce/Doctrine/EntityStoreDeleterTest.php), [PHPUnit for 2.0+ CE/EE](src/MagentoORM/unit/Deleter/V2_0ce/Doctrine/EntityStoreDeleterTest.php))

# Families

## Global families data (table `eav_attribute_set`)

* [x] repository [Interface](src/MagentoORM/Repository/FamilyRepositoryInterface.php)
  * [Standard DML implementation](src/MagentoORM/Repository/Doctrine/FamilyRepository.php) ([PHPUnit](src/MagentoORM/unit/Repository/Doctrine/FamilyRepositoryTest.php))
* [x] persister [Interface](src/MagentoORM/Persister/FamilyPersisterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Persister/StandardDML/Family/StandardFamilyPersister.php) ([PHPUnit for 1.9CE/1.14EE](src/MagentoORM/unit/Persister/V1_9ce/StandardDML/Family/StandardFamilyPersisterTest.php), [PHPUnit for 2.0+ CE/EE](src/MagentoORM/unit/Persister/V2_0ce/StandardDML/Family/StandardFamilyPersisterTest.php))
  * [MySQL-specific flat file implementation](src/MagentoORM/Persister/FlatFile/Family/StandardFamilyPersister.php)
* [x] deleter [Interface](src/MagentoORM/Deleter/FamilyDeleterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Deleter/Doctrine/FamilyDeleter.php) ([PHPUnit for 1.9CE/1.14EE](src/MagentoORM/unit/Deleter/V1_9ce/Doctrine/FamilyDeleterTest.php), [PHPUnit for 2.0+ CE/EE](src/MagentoORM/unit/Deleter/V2_0ce/Doctrine/FamilyDeleterTest.php))

# Attributes

## Catalog Attributes data + extensions (tables `eav_attribute` and `catalog_eav_attribute`)

* [x] repository [Interface](src/MagentoORM/Repository/AttributeRepositoryInterface.php)
  * [Standard DML implementation for 1.9CE/1.14EE](src/MagentoORM/Repository/V1_9ce/Doctrine/ProductAttributeRepository.php) ([PHPUnit](src/MagentoORM/unit/Repository/V1_9ce/Doctrine/ProductAttributeRepositoryTest.php))
  * [Standard DML implementation for 2.0 CE/EE](src/MagentoORM/Repository/V2_0ce/Doctrine/ProductAttributeRepository.php) ([PHPUnit](src/MagentoORM/unit/Repository/V2_0ce/Doctrine/ProductAttributeRepositoryTest.php))
* [x] persister [Interface](src/MagentoORM/Persister/AttributePersisterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Persister/StandardDML/Attribute/StandardAttributePersister.php) ([PHPUnit for 1.9CE/1.14EE](src/MagentoORM/unit/Persister/V1_9ce/StandardDML/Attribute/AttributePersisterTest.php), [PHPUnit for 2.0+ CE/EE](src/MagentoORM/unit/Persister/V2_0ce/StandardDML/Attribute/AttributePersisterTest.php))
  * [MySQL-specific flat file implementation](src/MagentoORM/Persister/FlatFile/Attribute/StandardAttributePersister.php)
* [x] deleter [Interface](src/MagentoORM/Deleter/AttributeDeleterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Deleter/Doctrine/AttributeDeleter.php) ([PHPUnit for 1.9CE/1.14EE](src/MagentoORM/unit/Deleter/V1_9ce/Doctrine/AttributeDeleterTest.php), [PHPUnit for 2.0+ CE/EE](src/MagentoORM/unit/Deleter/V2_0ce/Doctrine/AttributeDeleterTest.php))

## Attribute groups (table `eav_attribute_group`)

* [x] repository [Interface](src/MagentoORM/Repository/AttributeGroupRepositoryInterface.php)
  * [Standard DML implementation](src/MagentoORM/Repository/Doctrine/AttributeGroupRepository.php)  ([PHPUnit for 1.9CE/1.14EE](src/MagentoORM/unit/Repository/V1_9ce/Doctrine/AttributeGroupRepositoryTest.php), [PHPUnit for 2.0+ CE/EE](src/MagentoORM/unit/Repository/V2_0ce/Doctrine/AttributeGroupRepositoryTest.php))
* [x] persister [Interface](src/MagentoORM/Persister/AttributeGroupPersisterInterface.php)
  * [Standard DML implementation for 1.9CE/1.14EE](src/MagentoORM/Persister/StandardDML/V1_9ce/Attribute/AttributeGroupPersister.php) ([PHPUnit](src/MagentoORM/unit/Persister/V1_9ce/StandardDML/Attribute/AttributeGroupPersisterTest.php))
  * [Standard DML implementation for 2.0 CE/EE](src/MagentoORM/Persister/StandardDML/V2_0ce/Attribute/AttributeGroupPersister.php) ([PHPUnit](src/MagentoORM/unit/Persister/V2_0ce/StandardDML/Attribute/AttributeGroupPersisterTest.php))
  * [MySQL-specific flat file implementation](src/MagentoORM/Persister/FlatFile/Attribute/AttributeGroupPersister.php)
* [x] deleter [Interface](src/MagentoORM/Deleter/AttributeGroupDeleterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Deleter/Doctrine/AttributeGroupDeleter.php) ([PHPUnit for 1.9CE/1.14EE](src/MagentoORM/unit/Deleter/V1_9ce/Doctrine/AttributeGroupDeleterTest.php), [PHPUnit for 2.0+ CE/EE](src/MagentoORM/unit/Deleter/V2_0ce/Doctrine/AttributeGroupDeleterTest.php))

## Attribute labels (table `eav_attribute_label`)

* [x] repository [Interface](src/MagentoORM/Repository/AttributeLabelRepositoryInterface.php)
  * [Standard DML implementation](src/MagentoORM/Repository/Doctrine/AttributeLabelRepository.php) ([PHPUnit](src/MagentoORM/unit/Repository/Doctrine/AttributeLabelRepositoryTest.php))
* [x] persister [Interface](src/MagentoORM/Persister/AttributeLabelPersisterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Persister/StandardDML/Attribute/AttributeLabelPersister.php) ([PHPUnit for 1.9CE/1.14EE](src/MagentoORM/unit/Persister/V1_9ce/StandardDML/Attribute/AttributeLabelPersisterTest.php), [PHPUnit for 2.0+ CE/EE](src/MagentoORM/unit/Persister/V2_0ce/StandardDML/Attribute/AttributeLabelPersisterTest.php))
  * [MySQL-specific flat file implementation](src/MagentoORM/Persister/FlatFile/Attribute/AttributeLabelPersister.php)
* [x] deleter [Interface](src/MagentoORM/Deleter/AttributeLabelDeleterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Deleter/Doctrine/AttributeLabelDeleter.php) ([PHPUnit for 1.9CE/1.14EE](src/MagentoORM/unit/Deleter/V1_9ce/Doctrine/AttributeLabelDeleterTest.php), [PHPUnit for 2.0+ CE/EE](src/MagentoORM/unit/Deleter/V2_0ce/Doctrine/AttributeLabelDeleterTest.php))

## Attribute options (table `eav_attribute_option`)

* [x] repository [Interface](src/MagentoORM/Repository/AttributeOptionRepositoryInterface.php)
  * [Standard DML implementation](src/MagentoORM/Repository/Doctrine/AttributeOptionRepository.php) ([PHPUnit](src/MagentoORM/unit/Repository/Doctrine/AttributeOptionRepositoryTest.php))
* [x] persister [Interface](src/MagentoORM/Persister/AttributeOptionPersisterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Persister/StandardDML/Attribute/AttributeOptionPersister.php) ([PHPUnit for 1.9CE/1.14EE](src/MagentoORM/unit/Persister/V1_9ce/StandardDML/Attribute/AttributeOptionPersisterTest.php), [PHPUnit for 2.0+ CE/EE](src/MagentoORM/unit/Persister/V2_0ce/StandardDML/Attribute/AttributeOptionPersisterTest.php))
  * [MySQL-specific flat file implementation](src/MagentoORM/Persister/FlatFile/Attribute/AttributeOptionPersister.php)
* [x] deleter [Interface](src/MagentoORM/Deleter/AttributeOptionDeleterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Deleter/Doctrine/AttributeOptionDeleter.php) ([PHPUnit for 1.9CE/1.14EE](src/MagentoORM/unit/Deleter/V1_9ce/Doctrine/AttributeOptionDeleterTest.php), [PHPUnit for 2.0+ CE/EE](src/MagentoORM/unit/Deleter/V2_0ce/Doctrine/AttributeOptionDeleterTest.php))

## Attribute option values (table `eav_attribute_option_value`)

* [x] repository [Interface](src/MagentoORM/Repository/AttributeOptionValueRepositoryInterface.php)
  * [Standard DML implementation](src/MagentoORM/Repository/Doctrine/AttributeOptionValueRepository.php) ([PHPUnit](src/MagentoORM/unit/Repository/Doctrine/AttributeOptionValueRepositoryTest.php))
* [x] persister [Interface](src/MagentoORM/Persister/AttributeOptionValuePersisterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Persister/StandardDML/Attribute/AttributeOptionValuePersister.php) ([PHPUnit for 1.9CE/1.14EE](src/MagentoORM/unit/Persister/V1_9ce/StandardDML/Attribute/AttributeOptionValuePersisterTest.php), [PHPUnit for 2.0+ CE/EE](src/MagentoORM/unit/Persister/V2_0ce/StandardDML/Attribute/AttributeOptionValuePersisterTest.php))
  * [MySQL-specific flat file implementation](src/MagentoORM/Persister/FlatFile/Attribute/AttributeOptionValuePersister.php)
* [x] deleter [Interface](src/MagentoORM/Deleter/AttributeOptionValueDeleterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Deleter/Doctrine/AttributeOptionValueDeleter.php) ([PHPUnit for 1.9CE/1.14EE](src/MagentoORM/unit/Deleter/V1_9ce/Doctrine/AttributeOptionValueDeleterTest.php), [PHPUnit for 2.0+ CE/EE](src/MagentoORM/unit/Deleter/V2_0ce/Doctrine/AttributeOptionValueDeleterTest.php))

## Attribute to entity linking (table `eav_entity_attribute`)

* [x] repository [Interface](src/MagentoORM/Repository/EntityAttributeRepositoryInterface.php) 
  * [Standard DML implementation](src/MagentoORM/Repository/Doctrine/EntityAttributeRepository.php) ([PHPUnit](src/MagentoORM/unit/Repository/Doctrine/EntityAttributeRepositoryTest.php))
* [x] persister [Interface](src/MagentoORM/Persister/EntityAttributePersisterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Persister/StandardDML/Attribute/StandardEntityAttributePersister.php) ([PHPUnit for 1.9CE/1.14EE](src/MagentoORM/unit/Persister/V1_9ce/StandardDML/Attribute/EntityAttributePersisterTest.php), [PHPUnit for 2.0+ CE/EE](src/MagentoORM/unit/Persister/V2_0ce/StandardDML/Attribute/EntityAttributePersisterTest.php))
* [x] deleter [Interface](src/MagentoORM/Deleter/EntityAttributeDeleterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Deleter/Doctrine/EntityAttributeDeleter.php) ([PHPUnit for 1.9CE/1.14EE](src/MagentoORM/unit/Deleter/V1_9ce/Doctrine/EntityAttributeDeleterTest.php), [PHPUnit for 2.0+ CE/EE](src/MagentoORM/unit/Deleter/V2_0ce/Doctrine/EntityAttributeDeleterTest.php))

# Products

## Product entities (table `catalog_product_entity`)

* [x] repository [Interface](src/MagentoORM/Repository/ProductRepositoryInterface.php)
  * [Standard DML implementation](src/MagentoORM/Repository/Doctrine/ProductRepository.php) ([PHPUnit for 1.9CE/1.14EE](src/MagentoORM/unit/Repository/V1_9ce/Doctrine/ProductRepositoryTest.php), [PHPUnit for 2.0+ CE/EE](src/MagentoORM/unit/Repository/V2_0ce/Doctrine/ProductRepositoryTest.php))
* [x] persister [Interface](src/MagentoORM/Persister/ProductPersisterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Persister/StandardDML/Product/SimpleProductPersister.php)
  * [MySQL-specific flat file implementation](src/MagentoORM/Persister/FlatFile/Product/SimpleProductPersister.php)
* [x] delete [Interface](src/MagentoORM/Deleter/ProductDeleterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Deleter/Doctrine/ProductDeleter.php)

## Datetime values (table `catalog_product_entity_datetime`)

* [x] repository [Interface](src/MagentoORM/Repository/ProductAttributeValueRepositoryBackendInterface.php)
  * [Standard DML implementation](src/MagentoORM/Repository/Doctrine/ProductAttributeValueRepository.php) ([PHPUnit](src/MagentoORM/unit/Repository/Doctrine/ProductAttributeDatetimeValueRepositoryTest.php))
* [x] persister [Interface](src/MagentoORM/Persister/AttributeValuePersisterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Persister/StandardDML/AttributeValue/DecimalAttributeValuePersister.php)
  * [MySQL-specific flat file implementation](src/MagentoORM/Persister/FlatFile/AttributeValue/DatetimeAttributeValuePersister.php)
* [ ] deleter

## Decimal values (table `catalog_product_entity_decimal`)

* [x] repository [Interface](src/MagentoORM/Repository/ProductAttributeValueRepositoryBackendInterface.php)
  * [Standard DML implementation](src/MagentoORM/Repository/Doctrine/ProductAttributeValueRepository.php) ([PHPUnit](src/MagentoORM/unit/Repository/Doctrine/ProductAttributeDecimalValueRepositoryTest.php))
* [x] persister [Interface](src/MagentoORM/Persister/AttributeValuePersisterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Persister/StandardDML/AttributeValue/DecimalAttributeValuePersister.php)
  * [MySQL-specific flat file implementation](src/MagentoORM/Persister/FlatFile/AttributeValue/DecimalAttributeValuePersister.php)
* [ ] deleter

## Integer values (table `catalog_product_entity_int`)

* [x] repository [Interface](src/MagentoORM/Repository/ProductAttributeValueRepositoryBackendInterface.php)
  * [Standard DML implementation](src/MagentoORM/Repository/Doctrine/ProductAttributeValueRepository.php) ([PHPUnit](src/MagentoORM/unit/Repository/Doctrine/ProductAttributeIntegerValueRepositoryTest.php))
* [x] persister [Interface](src/MagentoORM/Persister/AttributeValuePersisterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Persister/StandardDML/AttributeValue/IntegerAttributeValuePersister.php)
  * [MySQL-specific flat file implementation](src/MagentoORM/Persister/FlatFile/AttributeValue/IntegerAttributeValuePersister.php)
* [ ] deleter

## Text values (table `catalog_product_entity_text`)

* [x] repository [Interface](src/MagentoORM/Repository/ProductAttributeValueRepositoryBackendInterface.php)
  * [Standard DML implementation](src/MagentoORM/Repository/Doctrine/ProductAttributeValueRepository.php) ([PHPUnit](src/MagentoORM/unit/Repository/Doctrine/ProductAttributeTextValueRepositoryTest.php))
* [x] persister [Interface](src/MagentoORM/Persister/AttributeValuePersisterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Persister/StandardDML/AttributeValue/TextAttributeValuePersister.php)
  * [MySQL-specific flat file implementation](src/MagentoORM/Persister/FlatFile/AttributeValue/TextAttributeValuePersister.php)
* [ ] deleter

## Varchar values (table `catalog_product_entity_varchar`)

* [x] repository [Interface](src/MagentoORM/Repository/ProductAttributeValueRepositoryBackendInterface.php)
  * [Standard DML implementation](src/MagentoORM/Repository/Doctrine/ProductAttributeValueRepository.php) ([PHPUnit](src/MagentoORM/unit/Repository/Doctrine/ProductAttributeVarcharValueRepositoryTest.php))
* [x] persister [Interface](src/MagentoORM/Persister/AttributeValuePersisterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Persister/StandardDML/AttributeValue/VarcharAttributeValuePersister.php)
  * [MySQL-specific flat file implementation](src/MagentoORM/Persister/FlatFile/AttributeValue/VarcharAttributeValuePersister.php)
* [ ] deleter

## Super attribute relations (table `catalog_product_entity_super_attribute`)

* [ ] repository
* [x] persister [Interface](src/MagentoORM/Persister/SuperAttributePersisterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Persister/StandardDML/SuperAttribute/ProductSuperAttributePersister.php)
  * [MySQL-specific flat file implementation](src/MagentoORM/Persister/FlatFile/SuperAttribute/ProductSuperAttributePersister.php)
* [ ] deleter

## Super link relations (table `catalog_product_entity_super_link`)

* [ ] repository
* [x] persister [Interface](src/MagentoORM/Persister/SuperLinkPersisterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Persister/StandardDML/SuperLink/ProductSuperLinkPersister.php)
  * [MySQL-specific flat file implementation](src/MagentoORM/Persister/FlatFile/SuperLink/ProductSuperLinkPersister.php)
* [ ] deleter

## Super link attribute label (table `catalog_product_entity_super_attribute_label`)

* [ ] repository
* [ ] persister
* [ ] deleter

## Super link attribute pricing (table `catalog_product_entity_super_attribute_pricing`)

* [ ] repository
* [ ] persister
* [ ] deleter

## Tier prices (table `catalog_product_entity_tier_price`)

* [ ] repository
* [ ] persister
* [ ] deleter

## Product price index (table `catalog_product_entity_group_price`)

* [ ] repository
* [ ] persister
* [ ] deleter

## Product link types (table `catalog_product_link_type`)

* [ ] repository
* [ ] persister
* [ ] deleter

## Product linking (table `catalog_product_link`)

* [ ] repository
* [ ] persister
* [ ] deleter

## Product linking attribute setup (table `catalog_product_link_attribute`)

* [ ] repository
* [ ] persister
* [ ] deleter

## Product linking attribute data - decimal (table `catalog_product_link_attribute_decimal`)

* [ ] repository
* [ ] persister
* [ ] deleter

## Product linking attribute data - integer (table `catalog_product_link_attribute_int`)

* [ ] repository
* [ ] persister
* [ ] deleter

## Product linking attribute data - varchar (table `catalog_product_link_attribute_varchar`)

* [ ] repository
* [ ] persister
* [ ] deleter

# Categories

## Category entities (table `catalog_category_entity`)

* [ ] repository
* [x] persister [Interface](src/MagentoORM/Persister/CategoryPersisterInterface.php)
* [ ] deleter

## Datetime values (table `catalog_category_entity_datetime`)

* [ ] repository
* [x] persister [Interface](src/MagentoORM/Persister/AttributeValuePersisterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Persister/StandardDML/AttributeValue/DecimalAttributeValuePersister.php)
  * [MySQL-specific flat file implementation](src/MagentoORM/Persister/FlatFile/AttributeValue/DatetimeAttributeValuePersister.php)
* [ ] deleter

## Decimal values (table `catalog_category_entity_decimal`)

* [ ] repository
* [x] persister [Interface](src/MagentoORM/Persister/AttributeValuePersisterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Persister/StandardDML/AttributeValue/DecimalAttributeValuePersister.php)
  * [MySQL-specific flat file implementation](src/MagentoORM/Persister/FlatFile/AttributeValue/DecimalAttributeValuePersister.php)
* [ ] deleter

## Integer values (table `catalog_category_entity_int`)

* [ ] repository
* [x] persister [Interface](src/MagentoORM/Persister/AttributeValuePersisterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Persister/StandardDML/AttributeValue/IntegerAttributeValuePersister.php)
  * [MySQL-specific flat file implementation](src/MagentoORM/Persister/FlatFile/AttributeValue/IntegerAttributeValuePersister.php)
* [ ] deleter

## Text values (table `catalog_category_entity_text`)

* [ ] repository
* [x] persister [Interface](src/MagentoORM/Persister/AttributeValuePersisterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Persister/StandardDML/AttributeValue/TextAttributeValuePersister.php)
  * [MySQL-specific flat file implementation](src/MagentoORM/Persister/FlatFile/AttributeValue/TextAttributeValuePersister.php)
* [ ] deleter

## Varchar values (table `catalog_category_entity_varchar`)

* [ ] repository
* [x] persister [Interface](src/MagentoORM/Persister/AttributeValuePersisterInterface.php)
  * [Standard DML implementation](src/MagentoORM/Persister/StandardDML/AttributeValue/VarcharAttributeValuePersister.php)
  * [MySQL-specific flat file implementation](src/MagentoORM/Persister/FlatFile/AttributeValue/VarcharAttributeValuePersister.php)
* [ ] deleter

## Category product list (table `catalog_category_product`)

* [ ] repository
* [ ] persister
* [ ] deleter

## Category product list index (table `catalog_category_product_index`)

* [ ] persister

# Media gallery

## Media assets (table `catalog_product_entity_gallery`)

* [ ] repository
* [ ] persister
* [ ] deleter

## Media attributes (table `catalog_product_entity_media_gallery`)

* [ ] repository
* [ ] persister
* [ ] deleter

## Media locales (table `catalog_product_entity_media_gallery_value`)

* [ ] repository
* [ ] persister
* [ ] deleter

# Inventory

## Product inventories

* [ ] repository
* [ ] persister
* [ ] deleter

# Indexes

* [ ] Index triggering

# Mapping

* [ ] Family mapping
* [ ] Attribute mapping
* [ ] Attribute value option mapping
