# Documentation

## TL;DR

This package is a toolset to manipulate data in a Magento database via `doctrine/dbal`, via a hybrid ORM/ODM.

It is built to bring Magento synchronization into Akeneo PIM and help you manage a complex hybryd flat/EAV database.

3 components and 1 Symfony bundle are composing this package :

* `Kiboko\MagentoORM` is the ORM/ODM, bringing data representation objects and storage management.
* `Kiboko\MagentoMapper` is used to ease the mapping between your Magento instance and your Akeneo PIM.
* `Kiboko\MagentoSerializer` a toolset to transform Akeneo PIM CSV files into Magento data representation objects and backwards
* `Kiboko\MagentoORMBundle` is the glue between all theses components and Akeneo PIM's **BatchBundle**

## The Magento Driver, a hybrid ORM/ODM

### What's inside the box?

This component has 3 primary actions :

* Load Magento Data
* Write Magento Data
* Delete Magento Data

Additionally, there are 2 ways of writing data :

* With standard *DML* queries (`INSERT` and `UPDATE` queries)
* With MySQL CSV capabilities (`LOAD [LOCAL] DATA INFILE` queries) for high volumes of data and high-speed requirements

The component is built around Doctrine's DBAL and PHP League's Flysystem, two high end tools for data manipulation.

### Architecture

The driver is split into several tools, each of them having its implementation for a specific data type.

* Query Builders
* Data Repositories
* Data Persisters
* Data Deleters

## Usage

### [Entity types](entity-types.md)

* [Initializing the Query Builder](entity-types.md#initializing-the-query-builder)
* [Initializing the Repository](#initializing-the-repository)

### [Families](families.md)

* [Initializing the Query Builder](families.md#initializing-the-query-builder)
* [Initializing the Repository](families.md#initializing-the-repository)

### [Entity to Attribute relations](entity-attributes.md)

### [Product attributes](product-attributes.md)

* [Initializing the Query Builder](product-attributes.md#initializing-the-query-builder)
* [Initializing the Repository](product-attributes.md#initializing-the-repository)
* [Using the Cached Repository](product-attributes.md#using-the-cached-repository)
* [Persisting data](product-attributes.md#persisting-data)
  * [Portable DML](product-attributes.md#portable-dml)
  * [MySQL specific, CSV direct importer](product-attributes.md#mysql-specific-csv-direct-importer)
* [Deleting data](product-attributes.md#deleting-data)

### [Product values](product-values.md)

