<?php

namespace unit\Kiboko\Component\MagentoORM\Deleter\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoORM\Deleter\CatalogAttributeDeleterInterface;
use Kiboko\Component\MagentoORM\Deleter\Doctrine\CatalogAttributeDeleter;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\ProductAttributeQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoORM\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture\FallbackResolver;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture\Loader;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture\LoaderInterface;

abstract class AbstractCatalogAttributeDeleter extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var CatalogAttributeDeleterInterface
     */
    protected $deleter;

    /**
     * @var LoaderInterface
     */
    private $fixturesLoader;

    /**
     * @return string
     */
    abstract protected function getVersion();

    /**
     * @return string
     */
    abstract protected function getEdition();

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

        $schemaBuilder = new DoctrineSchemaBuilder(
            $this->getDoctrineConnection(), $this->schema, $this->getVersion(), $this->getEdition());
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
            new FallbackResolver($schemaBuilder->getFixturesPath()),
            $this->getVersion(),
            $this->getEdition()
        );

        $schemaBuilder->hydrateEntityTypeTable(
            'catalog_eav_attribute',
            DoctrineSchemaBuilder::CONTEXT_DELETER
        );

        $schemaBuilder->hydrateFamilyTable(
            'catalog_eav_attribute',
            DoctrineSchemaBuilder::CONTEXT_DELETER
        );

        $schemaBuilder->hydrateAttributeTable(
            'catalog_eav_attribute',
            DoctrineSchemaBuilder::CONTEXT_DELETER
        );

        $schemaBuilder->hydrateCatalogAttributeExtensionsTable(
            'catalog_eav_attribute',
            DoctrineSchemaBuilder::CONTEXT_DELETER
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

        $this->deleter = null;
        $this->doctrineConnection = null;
        $this->connection = null;
        $this->pdo = null;
    }
}
