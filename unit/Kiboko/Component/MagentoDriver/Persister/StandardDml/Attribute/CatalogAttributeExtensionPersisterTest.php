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
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\FallbackResolver;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\LoaderInterface;

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

    /**
     * @var LoaderInterface
     */
    private $fixturesLoader;

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        $dataSet = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([]);

        return $dataSet;
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

        $this->fixturesLoader = new Loader(
            new FallbackResolver($schemaBuilder->getFixturesPath()),
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateEntityTypeTable(
            'catalog_eav_attribute',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateAttributeTable(
            'catalog_eav_attribute',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateCatalogAttributeExtensionsTable(
            'catalog_eav_attribute',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

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

        $expected = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            'catalog_eav_attribute' => [
                [
                    'attribute_id' => 79,
                    'frontend_input_renderer' => null,
                    'is_global' => 1,
                    'is_visible' => 1,
                    'is_searchable' => 0,
                    'is_filterable' => 0,
                    'is_comparable' => 0,
                    'is_visible_on_front' => 0,
                    'is_html_allowed_on_front' => 0,
                    'is_used_for_price_rules' => 0,
                    'is_filterable_in_search' => 0,
                    'used_in_product_listing' => 0,
                    'used_for_sort_by' => 0,
                    'is_configurable' => 0,
                    'apply_to' => null,
                    'is_visible_in_advanced_search' => 0,
                    'position' => 20,
                    'is_wysiwyg_enabled' => 0,
                    'is_used_for_promo_rules' => 0,
                ],
            ],
        ]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_eav_attribute');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testInsertOne()
    {
        $this->persister->initialize();
        $this->persister->persist(new CatalogAttributeExtension(
            122,     // AttributeId
            null,   // FrontendInputRendererClassName
            1,      // Global
            1,      // Visible
            0,      // Searchable
            0,      // Filterable
            0,      // Comparable
            0,      // VisibleOnFront
            0,      // HtmlAllowedOnFront
            0,      // UsedForPriceRules
            0,      // FilterableInSearch
            0,      // UsedInProductListing
            0,      // UsedForSortBy
            0,      // Configurable
            null,   // ProductTypesApplyingTo
            0,      // VisibleInAdvancedSearch
            20,     // Position
            0,      // WysiwygEnabled
            0,      // UsedForPromoRules
            0,      // RequiredInAdminStore (M2)
            0,      // UsedInGrid (M2)
            0,      // VisibleInGrid (M2)
            0,      // FilterableInGrid (M2)
            0,      // SearchWeight (M2)
            [],     // AdditionalData (M2)
            null    // Note
        ));
        $this->persister->flush();

        $expected = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            'catalog_eav_attribute' => [
                [
                    'attribute_id' => 79,
                    'frontend_input_renderer' => null,
                    'is_global' => 1,
                    'is_visible' => 1,
                    'is_searchable' => 0,
                    'is_filterable' => 0,
                    'is_comparable' => 0,
                    'is_visible_on_front' => 0,
                    'is_html_allowed_on_front' => 0,
                    'is_used_for_price_rules' => 0,
                    'is_filterable_in_search' => 0,
                    'used_in_product_listing' => 0,
                    'used_for_sort_by' => 0,
                    'is_configurable' => 0,
                    'apply_to' => null,
                    'is_visible_in_advanced_search' => 0,
                    'position' => 20,
                    'is_wysiwyg_enabled' => 0,
                    'is_used_for_promo_rules' => 0,
                ],
                [
                    'attribute_id' => 122,
                    'frontend_input_renderer' => null,
                    'is_global' => 1,
                    'is_visible' => 1,
                    'is_searchable' => 0,
                    'is_filterable' => 0,
                    'is_comparable' => 0,
                    'is_visible_on_front' => 0,
                    'is_html_allowed_on_front' => 0,
                    'is_used_for_price_rules' => 0,
                    'is_filterable_in_search' => 0,
                    'used_in_product_listing' => 0,
                    'used_for_sort_by' => 0,
                    'is_configurable' => 0,
                    'apply_to' => null,
                    'is_visible_in_advanced_search' => 0,
                    'position' => 20,
                    'is_wysiwyg_enabled' => 0,
                    'is_used_for_promo_rules' => 0,
                ],
            ],
        ]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_eav_attribute');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testUpdateOneExisting()
    {
        $this->persister->initialize();
        $this->persister->persist(new CatalogAttributeExtension(
            79,     // AttributeId
            null,   // FrontendInputRendererClassName
            1,      // Global
            1,      // Visible
            0,      // Searchable
            0,      // Filterable
            0,      // Comparable
            0,      // VisibleOnFront
            0,      // HtmlAllowedOnFront
            0,      // UsedForPriceRules
            0,      // FilterableInSearch
            0,      // UsedInProductListing
            0,      // UsedForSortBy
            0,      // Configurable
            null,   // ProductTypesApplyingTo
            0,      // VisibleInAdvancedSearch
            20,     // Position
            0,      // WysiwygEnabled
            0,      // UsedForPromoRules
            0,      // RequiredInAdminStore (M2)
            0,      // UsedInGrid (M2)
            0,      // VisibleInGrid (M2)
            0,      // FilterableInGrid (M2)
            0,      // SearchWeight (M2)
            [],     // AdditionalData (M2)
            null    // Note
        ));
        $this->persister->flush();

        $expected = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            'catalog_eav_attribute' => [
                [
                    'attribute_id' => 79,
                    'frontend_input_renderer' => null,
                    'is_global' => 1,
                    'is_visible' => 1,
                    'is_searchable' => 0,
                    'is_filterable' => 0,
                    'is_comparable' => 0,
                    'is_visible_on_front' => 0,
                    'is_html_allowed_on_front' => 0,
                    'is_used_for_price_rules' => 0,
                    'is_filterable_in_search' => 0,
                    'used_in_product_listing' => 0,
                    'used_for_sort_by' => 0,
                    'is_configurable' => 0,
                    'apply_to' => null,
                    'is_visible_in_advanced_search' => 0,
                    'position' => 20,
                    'is_wysiwyg_enabled' => 0,
                    'is_used_for_promo_rules' => 0,
                ],
            ],
        ]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_eav_attribute');

        $this->assertDataSetsEqual($expected, $actual);
    }
}
