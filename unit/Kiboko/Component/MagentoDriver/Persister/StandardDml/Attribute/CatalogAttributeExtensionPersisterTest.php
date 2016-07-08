<?php

namespace unit\Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Model\CatalogAttributeExtension;
use Kiboko\Component\MagentoDriver\Persister\CatalogAttributeExtensionPersisterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute\CatalogAttributeExtensionPersister;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;

class CatalogAttributeExtensionPersisterTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var CatalogAttributeExtensionPersisterInterface
     */
    private $persister;

    private $magentoVersion;

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        $dataset = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            $this->getFixturesPathname('eav_entity_type', $GLOBALS['MAGENTO_VERSION'], $GLOBALS['MAGENTO_EDITION']));
        $dataset->addYamlFile($this->getFixturesPathname('eav_attribute', $GLOBALS['MAGENTO_VERSION'], $GLOBALS['MAGENTO_EDITION']));
        $dataset->addYamlFile($this->getFixturesPathname('catalog_eav_attribute', $GLOBALS['MAGENTO_VERSION'], $GLOBALS['MAGENTO_EDITION']));

        return $dataset;
    }

    private function truncateTables()
    {
        $platform = $this->getDoctrineConnection()->getDatabasePlatform();

        $this->getDoctrineConnection()->exec('SET FOREIGN_KEY_CHECKS=0');
        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_entity_type')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('catalog_eav_attribute')
        );
        $this->getDoctrineConnection()->exec('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function setUp()
    {
        $currentSchema = $this->getDoctrineConnection()->getSchemaManager()->createSchema();

        $this->schema = new Schema();

        $schemaBuilder = new DoctrineSchemaBuilder($this->getDoctrineConnection(), $this->schema);
        $schemaBuilder->ensureEntityTypeTable();
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureCatalogAttributeExtensionsTable();
        $schemaBuilder->ensureAttributeToEntityTypeLinks();
        $schemaBuilder->ensureCatalogAttributeExtensionsToAttributeLinks();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();

        parent::setUp();

        $this->magentoVersion = '1.9';

        $schemaBuilder->hydrateEntityTypeTable($GLOBALS['MAGENTO_VERSION'], $GLOBALS['MAGENTO_EDITION']);
        $schemaBuilder->hydrateAttributeTable($GLOBALS['MAGENTO_VERSION'], $GLOBALS['MAGENTO_EDITION']);

        $this->persister = new CatalogAttributeExtensionPersister(
            $this->getDoctrineConnection(),
            ProductAttributeQueryBuilder::getDefaultExtraTable()
        );
    }

    protected function tearDown()
    {
        $this->truncateTables();
        parent::tearDown();

        $this->persister = null;
    }

    public function testInsertNone()
    {
        $this->persister->initialize();
        $this->persister->flush();

        $this->assertTableRowCount('catalog_eav_attribute', 0);
    }

    public function testInsertOne()
    {
        $dataLoader = new Loader($this->getDoctrineConnection(), $GLOBALS['MAGENTO_VERSION'], $GLOBALS['MAGENTO_EDITION']);

        $this->persister->initialize();

        foreach ($dataLoader->walkData('catalog_eav_attribute') as $data) {
            $attribute = new CatalogAttributeExtension(
                $data['attribute_id'],
                $data['frontend_input_renderer'],
                $data['is_global'],
                $data['is_visible'],
                $data['is_searchable'],
                $data['is_filterable'],
                $data['is_comparable'],
                $data['is_visible_on_front'],
                $data['is_html_allowed_on_front'],
                $data['is_used_for_price_rules'],
                $data['is_filterable_in_search'],
                $data['used_in_product_listing'],
                $data['used_for_sort_by'],
                $data['is_configurable'],
                $data['apply_to'],
                $data['is_visible_in_advanced_search'],
                $data['position'],
                $data['is_wysiwyg_enabled'],
                $data['is_used_for_promo_rules']
            );
            $this->persister->persist($attribute);
        }

        $this->persister->flush();

        $this->assertTableRowCount('catalog_eav_attribute', 8);

        $expected = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            $this->getFixturesPathname('catalog_eav_attribute', $GLOBALS['MAGENTO_VERSION'], $GLOBALS['MAGENTO_EDITION']));

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_eav_attribute');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testUpdateOneExisting()
    {
        $dataLoader = new Loader($this->getDoctrineConnection(), $GLOBALS['MAGENTO_VERSION'], $GLOBALS['MAGENTO_EDITION']);

        $this->persister->initialize();

        foreach ($dataLoader->walkData('catalog_eav_attribute') as $data) {
            $attribute = new CatalogAttributeExtension(
                $data['attribute_id'],
                $data['frontend_input_renderer'],
                $data['is_global'],
                $data['is_visible'],
                $data['is_searchable'],
                $data['is_filterable'],
                $data['is_comparable'],
                $data['is_visible_on_front'],
                $data['is_html_allowed_on_front'],
                $data['is_used_for_price_rules'],
                $data['is_filterable_in_search'],
                $data['used_in_product_listing'],
                $data['used_for_sort_by'],
                $data['is_configurable'],
                $data['apply_to'],
                $data['is_visible_in_advanced_search'],
                $data['position'],
                $data['is_wysiwyg_enabled'],
                $data['is_used_for_promo_rules']
            );
            $this->persister->persist($attribute);
        }
        $this->persister->flush();

        $this->assertTableRowCount('catalog_eav_attribute', 8);

        $expected = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            $this->getFixturesPathname('catalog_eav_attribute', $GLOBALS['MAGENTO_VERSION'], $GLOBALS['MAGENTO_EDITION']));

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_eav_attribute');

        $this->assertDataSetsEqual($expected, $actual);
    }
}
