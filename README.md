# akeneo-magento-driver

This library is an API to make it easier to access Magento data from Akeneo PIM, or any application using Doctrine2 DBAL.

This library is the foundation for custom Magento connectors on top of Akeneo PIM, you can also build batches and commands on top of it.

_Note: This is a development preview, we are trying to make the best software as possible. Despite all the efforts we are deploying, some bugs may still be present, please report them at [Github](https://github.com/kiboko-labs/native-magento-driver/issues)._

## Why this library when there is PIMGento?

PIMGento is a good tool, but there are some drawbacks inherent to its import strategy

- PIMGento is a one-way connector, products which are deleted, incomplete or disabled in the PIM are kept active in Magento
- The medias imported with PIMGento are overriding previously existing medias in Magento, and therefore their orderings
- The product list ordering in categories is wiped out on each PIMGento import
- The URL key and URL Path generation is terrible and creates URL duplication issues with unreachable categories
- Some use cases including Community Editions of Akeneo and Magento breaks the catalog structure 

## Why not using Magento's SOAP API

This way has been explored by Akeneo and abandoned on version 1.4, the imports were too slow.

## Shouldn't this be as slow as the old SOAP connector?

No.

This driver uses a MySQL connection and the `LOAD DATA [LOCAL] INFILE` strategy, just like PIMGento does. Therefore, the import speeds should be comparable.

## Is this driver limited to Akeneo PIM product datum?

No.
 
This driver uses `doctrine/dbal` to read and update Magento's database. It also uses `league/flyststem` to synchronize media files.

So if your application uses Doctrine DBAL, you will be able to use it out of the box, managing products, media assets, inventory, taxes, etc...

## How to use it?

You may require the library in your `composer.json` :

```json
    "require": {
        ...
        "kiboko/native-magento-driver": "dev-master@dev"
    },
    "repositories": [
        ...
        {
            "type": "vcs",
            "url": "https://github.com/kiboko-labs/native-magento-driver.git",
            "branch": "master"
        }
    }
```

## What's the difference between `Entity` and `Model`?

An `Entity` maps to a document, using the EAV pattern. Typically products and categories.

A `Model` maps to a flat table.
