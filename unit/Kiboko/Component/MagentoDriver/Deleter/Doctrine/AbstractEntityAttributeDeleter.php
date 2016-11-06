<?php

namespace unit\Kiboko\Component\MagentoDriver\Deleter\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Deleter\EntityAttributeDeleterInterface;
use Kiboko\Component\MagentoDriver\Deleter\Doctrine\EntityAttributeDeleter;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\EntityAttributeQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\FallbackResolver;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\LoaderInterface;

abstract class AbstractEntityAttributeDeleter extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var EntityAttributeDeleterInterface
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
            'eav_entity_attribute',
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
            'eav_entity_attribute',
            DoctrineSchemaBuilder::CONTEXT_DELETER
        );

        return $dataset;
    }

    private function truncateTables()
    {
        $platform = $this->getDoctrineConnection()->getDatabasePlatform();

        $this->getDoctrineConnection()->exec('SET FOREIGN_KEY_CHECKS=0');

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute_group')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_entity_attribute')
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
        $schemaBuilder->ensureAttributeGroupTable();
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureEntityAttributeTable();

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

        $schemaBuilder->hydrateAttributeGroupTable(
            'eav_entity_attribute',
            DoctrineSchemaBuilder::CONTEXT_DELETER
        );

        $schemaBuilder->hydrateAttributeTable(
            'eav_entity_attribute',
            DoctrineSchemaBuilder::CONTEXT_DELETER
        );

        $schemaBuilder->hydrateEntityAttributeTable(
            'eav_entity_attribute',
            DoctrineSchemaBuilder::CONTEXT_DELETER
        );

        $this->deleter = new EntityAttributeDeleter(
            $this->getDoctrineConnection(),
            new EntityAttributeQueryBuilder(
                $this->getDoctrineConnection(),
                EntityAttributeQueryBuilder::getDefaultTable(),
                EntityAttributeQueryBuilder::getDefaultFields()
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
