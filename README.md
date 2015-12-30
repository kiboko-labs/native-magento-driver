# akeneo-magento-driver

This library is an API to make it easier to access to Magento data from Akeneo PIM, or simply an application using Doctrine2 DBAL.

This library is the foundation for custom Magento connectors on top of Akeneo PIM.

## Why this library when there is PIMGento?

PIMGento is a good tool, but there are some drawbacks inherent to its import strategy

- PIMGento is a one-way connector, products which are deleted, incomplete or disabled in the PIM are kept active in Magento
- The medias imported with PIMGento are overriding previously existing medias in Magento, and therefore their orderings
- The product list ordering in categories is wiped out on each PIMGento import
- The URL key and URL Path generation is terrible and creates URL duplication issues with unreachable categories

## Why not using the SOAP API

This way has been explored by Akeneo and abandoned on version 1.4, the imports were too slow.

## Shouldn't this be as slow as the old SOAP connector?

This driver uses a MySQL connection and the `LOAD DATA [LOCAL] INFILE` strategy, just like PIMGento does. Therefore, the import speeds should be comparable.

## Is this driver limited to Akeneo PIM product datum?

No, this driver uses Doctrine DBAL to read and update Magento's database.

So if your application uses Doctrine DBAL, you will be able to use it out of the box, managing products, media assets, inventory, taxes, etc...

## How to use it?

Simply require it in your `composer.json` :

`$ composer require luni/akeneo-magento-driver:*`

## To do:

- Implement EAV attribute filters
- Implement Index refresh
- Implement object factories