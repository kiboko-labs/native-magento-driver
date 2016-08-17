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
        $dataset = $this->fixturesLoader->initialDataSet(
            'catalog_eav_attribute',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

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

        $expected = $this->getDataSet();

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_eav_attribute');
        $actual->addTable('eav_entity_type');
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testInsertOne()
    {
        
        $catalogAttributeExtensionDatas = array(
            'ce' => array(
                '1.9' => array(
                    'is_global' => 1,                       // Global
                    'is_visible' => 1,                      // Visible
                    'is_searchable' => 0,                   // Searchable
                    'is_filterable' => 0,                   // Filterable
                    'is_comparable' => 0,                   // Comparable
                    'is_visible_on_front' => 0,             // VisibleOnFront
                    'is_html_allowed_on_front' => 0,        // HtmlAllowedOnFront
                    'is_used_for_price_rules' => 0,         // UsedForPriceRules
                    'is_filterable_in_search' => 0,         // FilterableInSearch
                    'used_in_product_listing' => 0,         // UsedInProductListing
                    'used_for_sort_by' => 0,                // UsedForSortBy
                    'is_configurable' => 0,                 // Configurable (M1)
                    'apply_to' => null,                     // ProductTypesApplyingTo
                    'is_visible_in_advanced_search' => 0,   // VisibleInAdvancedSearch
                    'position' => 20,                       // Position
                    'is_wysiwyg_enabled' => 0,              // WysiwygEnabled
                    'is_used_for_promo_rules' => 0,         // UsedForPromoRules
                ),
                '2.0' => array(
                    'is_global' => 1,                       // Global
                    'is_visible' => 1,                      // Visible
                    'is_searchable' => 0,                   // Searchable
                    'is_filterable' => 0,                   // Filterable
                    'is_comparable' => 0,                   // Comparable
                    'is_visible_on_front' => 0,             // VisibleOnFront
                    'is_html_allowed_on_front' => 0,        // HtmlAllowedOnFront
                    'is_used_for_price_rules' => 0,         // UsedForPriceRules
                    'is_filterable_in_search' => 0,         // FilterableInSearch
                    'used_in_product_listing' => 0,         // UsedInProductListing
                    'used_for_sort_by' => 0,                // UsedForSortBy
                    'apply_to' => null,                     // ProductTypesApplyingTo
                    'is_visible_in_advanced_search' => 0,   // VisibleInAdvancedSearch
                    'position' => 20,                       // Position
                    'is_wysiwyg_enabled' => 0,              // WysiwygEnabled
                    'is_used_for_promo_rules' => 0,         // UsedForPromoRules
                    'is_required_in_admin_store' => 0,      // RequiredInAdminStore (M2)
                    'is_used_in_grid' => 0,                 // UsedInGrid (M2)
                    'is_visible_in_grid' => 0,              // VisibleInGrid (M2)
                    'is_filterable_in_grid' => 0,           // FilterableInGrid (M2)
                    'search_weight' => 0,                   // SearchWeight (M2)
                    'additional_data' => [],                // AdditionalData (M2)
                ),
            )
        );
        
        $catalogAttributeExtensionRows = array(
            'ce' => array(
                '1.9' => array(
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
                ),
                '2.0' => array(
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
                    'apply_to' => null,
                    'is_visible_in_advanced_search' => 0,
                    'position' => 20,
                    'is_wysiwyg_enabled' => 0,
                    'is_used_for_promo_rules' => 0,
                    'is_required_in_admin_store' => 0,
                    'is_used_in_grid' => 0,
                    'is_visible_in_grid' => 0,
                    'is_filterable_in_grid' => 0,
                    'search_weight' => 0,
                    'additional_data' => null,
                ),
            )
        );
        
        $this->persister->initialize();
        $this->persister->persist(new CatalogAttributeExtension(
            122,     // AttributeId
            null,   // FrontendInputRendererClassName
            $catalogAttributeExtensionDatas[$GLOBALS['MAGENTO_EDITION']][$GLOBALS['MAGENTO_VERSION']] // Datas
        ));
        $this->persister->flush();

        $expected = $this->getDataSet();
        $expected->getTable('catalog_eav_attribute')->addRow($catalogAttributeExtensionRows[$GLOBALS['MAGENTO_EDITION']][$GLOBALS['MAGENTO_VERSION']]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_eav_attribute');
        $actual->addTable('eav_entity_type');
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testUpdateOneExisting()
    {
        $catalogAttributeExtensionDatas = array(
            'ce' => array(
                '1.9' => array(
                    'is_global' => 1,                       // Global
                    'is_visible' => 1,                      // Visible
                    'is_searchable' => 0,                   // Searchable
                    'is_filterable' => 0,                   // Filterable
                    'is_comparable' => 0,                   // Comparable
                    'is_visible_on_front' => 0,             // VisibleOnFront
                    'is_html_allowed_on_front' => 0,        // HtmlAllowedOnFront
                    'is_used_for_price_rules' => 0,         // UsedForPriceRules
                    'is_filterable_in_search' => 0,         // FilterableInSearch
                    'used_in_product_listing' => 0,         // UsedInProductListing
                    'used_for_sort_by' => 0,                // UsedForSortBy
                    'is_configurable' => 0,                 // Configurable (M1)
                    'apply_to' => null,                     // ProductTypesApplyingTo
                    'is_visible_in_advanced_search' => 0,   // VisibleInAdvancedSearch
                    'position' => 20,                       // Position
                    'is_wysiwyg_enabled' => 0,              // WysiwygEnabled
                    'is_used_for_promo_rules' => 0,         // UsedForPromoRules
                ),
                '2.0' => array(
                    'is_global' => 1,                       // Global
                    'is_visible' => 1,                      // Visible
                    'is_searchable' => 0,                   // Searchable
                    'is_filterable' => 0,                   // Filterable
                    'is_comparable' => 0,                   // Comparable
                    'is_visible_on_front' => 0,             // VisibleOnFront
                    'is_html_allowed_on_front' => 0,        // HtmlAllowedOnFront
                    'is_used_for_price_rules' => 0,         // UsedForPriceRules
                    'is_filterable_in_search' => 0,         // FilterableInSearch
                    'used_in_product_listing' => 0,         // UsedInProductListing
                    'used_for_sort_by' => 0,                // UsedForSortBy
                    'apply_to' => null,                     // ProductTypesApplyingTo
                    'is_visible_in_advanced_search' => 0,   // VisibleInAdvancedSearch
                    'position' => 20,                       // Position
                    'is_wysiwyg_enabled' => 0,              // WysiwygEnabled
                    'is_used_for_promo_rules' => 0,         // UsedForPromoRules
                    'is_required_in_admin_store' => 0,      // RequiredInAdminStore (M2)
                    'is_used_in_grid' => 0,                 // UsedInGrid (M2)
                    'is_visible_in_grid' => 0,              // VisibleInGrid (M2)
                    'is_filterable_in_grid' => 0,           // FilterableInGrid (M2)
                    'search_weight' => 0,                   // SearchWeight (M2)
                    'additional_data' => [],                // AdditionalData (M2)
                ),
            )
        );
        
        $this->persister->initialize();
        $this->persister->persist(new CatalogAttributeExtension(
            79,     // AttributeId
            null,   // FrontendInputRendererClassName
           $catalogAttributeExtensionDatas[$GLOBALS['MAGENTO_EDITION']][$GLOBALS['MAGENTO_VERSION']] // Datas
        ));
        $this->persister->flush();
        
        $catalogAttributeUpdated = array(
            'ce' => array(
                '1.9' => array(
                    array(
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
                    ),
            ),
                '2.0' => array(
                    array(
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
                        'apply_to' => null,
                        'is_visible_in_advanced_search' => 0,
                        'position' => 20,
                        'is_wysiwyg_enabled' => 0,
                        'is_used_for_promo_rules' => 0,
                        'is_required_in_admin_store' => 0,
                        'is_used_in_grid' => 0,
                        'is_visible_in_grid' => 0,
                        'is_filterable_in_grid' => 0,
                        'search_weight' => 0,
                        'additional_data' => null,
                        ),
                ),
            ),
        );

        $expected = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet(array('catalog_eav_attribute' => $catalogAttributeUpdated[$GLOBALS['MAGENTO_EDITION']][$GLOBALS['MAGENTO_VERSION']]));

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_eav_attribute');

        $this->assertDataSetsEqual($expected, $actual);
    }
}
