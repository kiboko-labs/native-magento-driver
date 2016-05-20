<?php

namespace unit\Luni\Component\MagentoDriver\Persister\Direct\Attribute;

use Doctrine\DBAL\Schema\Schema;
use Luni\Component\MagentoDriver\Model\CatalogAttributeExtension;
use Luni\Component\MagentoDriver\Persister\CatalogAttributeExtensionPersisterInterface;
use Luni\Component\MagentoDriver\Persister\Direct\Attribute\CatalogAttributeExtensionPersister;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Luni\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Luni\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Luni\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;

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

    private $magentoEdition;

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        $dataset = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            $this->getFixturesPathname('eav_entity_type', $this->magentoVersion, $this->magentoEdition));
        $dataset->addYamlFile($this->getFixturesPathname('eav_attribute', $this->magentoVersion, $this->magentoEdition));
        $dataset->addYamlFile($this->getFixturesPathname('catalog_eav_attribute', $this->magentoVersion, $this->magentoEdition));

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
        $this->magentoEdition = 'ce';

        $schemaBuilder->hydrateEntityTypeTable($this->magentoVersion, $this->magentoEdition);
        $schemaBuilder->hydrateAttributeTable($this->magentoVersion, $this->magentoEdition);

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
        $dataLoader = new Loader($this->getDoctrineConnection(), 'catalog_eav_attribute');

        $this->persister->initialize();

        foreach ($dataLoader->walkData($this->magentoVersion, $this->magentoEdition) as $data) {
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
            $this->getFixturesPathname('catalog_eav_attribute', $this->magentoVersion, $this->magentoEdition));

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_eav_attribute');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testUpdateOneExisting()
    {
        $dataLoader = new Loader($this->getDoctrineConnection(), 'catalog_eav_attribute');

        $this->persister->initialize();
        foreach ($dataLoader->walkData($this->magentoVersion, $this->magentoEdition) as $data) {
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
            $this->getFixturesPathname('catalog_eav_attribute', $this->magentoVersion, $this->magentoEdition));

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_eav_attribute');

        $this->assertDataSetsEqual($expected, $actual);
    }
}
