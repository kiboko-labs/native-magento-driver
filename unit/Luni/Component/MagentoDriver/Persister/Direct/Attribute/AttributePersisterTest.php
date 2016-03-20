<?php

namespace unit\Luni\Component\MagentoDriver\Persister\Direct\Attribute;

use Doctrine\DBAL\Schema\Schema;
use Luni\Component\MagentoDriver\Entity\Product\ProductInterface;
use Luni\Component\MagentoDriver\Model\Attribute;
use Luni\Component\MagentoDriver\Persister\AttributePersisterInterface;
use Luni\Component\MagentoDriver\Persister\Direct\Attribute\StandardAttributePersister;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilder;
use unit\Luni\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Luni\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Luni\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;

class AttributePersisterTest
    extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var AttributePersisterInterface
     */
    private $persister;

    private function truncateTables()
    {
        $platform = $this->getConnection()->getDatabasePlatform();

        $this->getConnection()->exec('SET FOREIGN_KEY_CHECKS=0');
        $this->getConnection()->exec(
            $platform->getTruncateTableSQL('eav_entity_type')
        );

        $this->getConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute')
        );
        $this->getConnection()->exec('SET FOREIGN_KEY_CHECKS=1');
    }

    protected function setUp()
    {
        parent::setUp();
        $this->initConnection();

        $currentSchema = $this->getConnection()->getSchemaManager()->createSchema();

        $this->schema = new Schema();

        $schemaBuilder = new DoctrineSchemaBuilder($this->connection, $this->schema);
        $schemaBuilder->ensureEntityTypeTable();
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureAttributeToEntityTypeLinks();
        $schemaBuilder->hydrateEntityTypeTable('1.9', 'ce');

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getConnection()->getDatabasePlatform()) as $sql) {
            $this->getConnection()->exec($sql);
        }

        $this->truncateTables();

        $this->persister = new StandardAttributePersister(
            $this->getConnection(),
            ProductAttributeQueryBuilder::getDefaultTable()
        );
    }

    protected function tearDown()
    {
        $this->truncateTables();
        $this->closeConnection();
        parent::tearDown();

        $this->persister = null;
    }

    public function testInsertNone()
    {
        $this->persister->initialize();
        $this->persister->flush();
    }

    public function testInsertOne()
    {
        $dataLoader = new Loader($this->connection, 'eav_attribute');

        $data = $dataLoader->readData('1.9', 'ce');
        $attribute = new Attribute(
            $data['entity_type_id'],
            $data['attribute_code'],
            $data['attribute_model'],
            $data['backend_model'],
            $data['backend_type'],
            $data['backend_table'],
            $data['frontend_model'],
            $data['frontend_input'],
            $data['frontend_label'],
            $data['frontend_class'],
            $data['source_model'],
            $data['is_required'],
            $data['is_user_defined'],
            $data['default_value'],
            $data['is_unique'],
            $data['note']
        );

        $this->persister->initialize();
        $this->persister->persist($attribute);
        $this->persister->flush();
    }

    public function testUpdateOneExisting()
    {
        $dataLoader = new Loader($this->connection, 'eav_attribute');

        $data = $dataLoader->readData('1.9', 'ce');
        $attribute = Attribute::buildNewWith(
            $data['attribute_id'],
            $data['entity_type_id'],
            $data['attribute_code'],
            $data['attribute_model'],
            $data['backend_model'],
            $data['backend_type'],
            $data['backend_table'],
            $data['frontend_model'],
            $data['frontend_input'],
            $data['frontend_label'],
            $data['frontend_class'],
            $data['source_model'],
            $data['is_required'],
            $data['is_user_defined'],
            $data['default_value'],
            $data['is_unique'],
            $data['note']
        );

        $this->persister->initialize();
        $this->persister->persist($attribute);
        $this->persister->flush();
    }
}
