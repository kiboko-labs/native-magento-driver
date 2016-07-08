<?php

namespace unit\Kiboko\Component\MagentoDriver\Deleter\Doctrine\Attribute;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Persister\CatalogAttributePersisterInterface;
use Kiboko\Component\MagentoDriver\Persister\CatalogAttributePersister;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute\CatalogAttributeExtensionPersister;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute\StandardAttributePersister;
use Kiboko\Component\MagentoDriver\Deleter\CatalogAttributeDeleterInterface;
use Kiboko\Component\MagentoDriver\Deleter\Doctrine\CatalogAttributeDeleter;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\FallbackResolver;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\LoaderInterface;

class CatalogAttributeDeleterTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var CatalogAttributeDeleterInterface
     */
    private $deleter;

    /**
     * @var CatalogAttributePersisterInterface
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
        $dataset = $this->fixturesLoader->expectedDataSet(
            'catalog_eav_attribute',
            DoctrineSchemaBuilder::CONTEXT_DELETER
        );

        return $dataset;
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getInitialDataSet()
    {
        $dataset = $this->fixturesLoader->initialDataSet(
            'catalog_eav_attribute',
            DoctrineSchemaBuilder::CONTEXT_DELETER
        );

        return $dataset;
    }

    private function truncateTables()
    {
        $platform = $this->getDoctrineConnection()->getDatabasePlatform();

        $this->getDoctrineConnection()->exec('SET FOREIGN_KEY_CHECKS=0');

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_entity_type')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute_set')
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

        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureFamilyTable();
        $schemaBuilder->ensureEntityTypeTable();
        $schemaBuilder->ensureCatalogAttributeExtensionsTable();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();

        parent::setUp();

        $this->fixturesLoader = new Loader(
            new FallbackResolver($schemaBuilder->getFixturesPath(), 'eav_entity_store'),
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateEntityTypeTable(
            'catalog_eav_attribute',
            DoctrineSchemaBuilder::CONTEXT_DELETER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateFamilyTable(
            'catalog_eav_attribute',
            DoctrineSchemaBuilder::CONTEXT_DELETER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateAttributeTable(
            'catalog_eav_attribute',
            DoctrineSchemaBuilder::CONTEXT_DELETER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateCatalogAttributeExtensionsTable(
            'catalog_eav_attribute',
            DoctrineSchemaBuilder::CONTEXT_DELETER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $this->persister = new CatalogAttributePersister(
            new StandardAttributePersister(
                $this->getDoctrineConnection(),
                ProductAttributeQueryBuilder::getDefaultTable()
            ),
            new CatalogAttributeExtensionPersister(
                $this->getDoctrineConnection(),
                ProductAttributeQueryBuilder::getDefaultExtraTable()
            )
        );

        $this->deleter = new CatalogAttributeDeleter(
            $this->getDoctrineConnection(),
            new ProductAttributeQueryBuilder(
                $this->getDoctrineConnection(),
                ProductAttributeQueryBuilder::getDefaultExtraTable(),
                ProductAttributeQueryBuilder::getDefaultTable(),
                ProductAttributeQueryBuilder::getDefaultEntityTable(),
                ProductAttributeQueryBuilder::getDefaultVariantTable(),
                ProductAttributeQueryBuilder::getDefaultFamilyTable(),
                ProductAttributeQueryBuilder::getDefaultExtraFields(),
                ProductAttributeQueryBuilder::getDefaultFields()
            )
        );
    }

    protected function tearDown()
    {
        $this->truncateTables();
        parent::tearDown();

        $this->persister = $this->deleter = null;
    }

    public function testRemoveNone()
    {
        $this->persister->initialize();

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_eav_attribute');
        $actual->addTable('eav_entity_type');
        $actual->addTable('eav_attribute_set');
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($this->getInitialDataSet(), $actual);
    }

    public function testRemoveOneById()
    {
        $this->persister->initialize();

        $this->deleter->deleteOneById(122);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_eav_attribute');
        $actual->addTable('eav_entity_type');
        $actual->addTable('eav_attribute_set');
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
    }

    public function testRemoveAllById()
    {
        $this->persister->initialize();

        $this->deleter->deleteAllById([122]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_eav_attribute');
        $actual->addTable('eav_entity_type');
        $actual->addTable('eav_attribute_set');
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
    }
}
