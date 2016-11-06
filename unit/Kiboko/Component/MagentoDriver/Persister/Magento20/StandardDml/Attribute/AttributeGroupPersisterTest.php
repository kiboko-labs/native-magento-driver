<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace unit\Kiboko\Component\MagentoDriver\Persister\Magento20\StandardDml\Attribute;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Model\Magento20\AttributeGroup;
use Kiboko\Component\MagentoDriver\Persister\AttributeGroupPersisterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute\AttributeGroupPersister;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\AttributeGroupQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\FallbackResolver;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\LoaderInterface;

class AttributeGroupPersisterTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var AttributeGroupPersisterInterface
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
            'eav_attribute_group',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        return $dataset;
    }

    private function truncateTables()
    {
        $platform = $this->getDoctrineConnection()->getDatabasePlatform();

        $this->getDoctrineConnection()->exec('SET FOREIGN_KEY_CHECKS=0');

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute_set')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute_group')
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
            $this->getDoctrineConnection(), $this->schema);
        $schemaBuilder->ensureFamilyTable();
        $schemaBuilder->ensureAttributeGroupTable();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();

        parent::setUp();

        $this->fixturesLoader = new Loader(
            new FallbackResolver($schemaBuilder->getFixturesPath()),
            '2.0', 'ce'
        );

        $schemaBuilder->hydrateAttributeGroupTable(
            'eav_attribute_group',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $schemaBuilder->hydrateFamilyTable(
            'eav_attribute_group',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $this->persister = new AttributeGroupPersister(
            $this->getDoctrineConnection(),
            AttributeGroupQueryBuilder::getDefaultTable()
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
        $actual->addTable('eav_attribute_group');
        $actual->addTable('eav_attribute_set');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testInsertOne()
    {
        $this->persister->initialize();
        
        $attributeGroup = new AttributeGroup(3, 'Prices', 1, 1);

        $attributeGroup[$GLOBALS['MAGENTO_EDITION']][$GLOBALS['MAGENTO_VERSION']];

        $this->persister->persist($attributeGroup[$GLOBALS['MAGENTO_EDITION']][$GLOBALS['MAGENTO_VERSION']]);
        $this->persister->flush();

        $this->assertEquals(3, $attributeGroup[$GLOBALS['MAGENTO_EDITION']][$GLOBALS['MAGENTO_VERSION']]->getId());

        $newAttributeGroup = array(
            'ce' => array(
                '1.9' => array(
                    'attribute_group_id' => 3,
                    'attribute_set_id' => 3,
                    'attribute_group_name' => 'Prices',
                    'sort_order' => 1,
                    'default_id' => 1,
                ),
                '2.0' => array(
                    'attribute_group_id' => 3,
                    'attribute_set_id' => 3,
                    'attribute_group_name' => 'Prices',
                    'sort_order' => 1,
                    'default_id' => 1,
                    'attribute_group_code' => 'price',
                    'tab_group_code' => null,
                )
            )
        );
        
        $expected = $this->getDataSet();
        $expected->getTable('eav_attribute_group')->addRow($newAttributeGroup[$GLOBALS['MAGENTO_EDITION']][$GLOBALS['MAGENTO_VERSION']]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_group');
        $actual->addTable('eav_attribute_set');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testUpdateOneExisting()
    {
        $this->persister->initialize();
        
        $attributeGroup = array(
            'ce' => array(
                '1.9' => AttributeGroup::buildNewWith(
                        1, 1, 'Updated', 1, 1
                ),
                '2.0' => AttributeGroup::buildNewWith(
                        1, 1, 'Updated', 1, 1, 'updated', null
                )
            )
        );

        $this->persister->persist($attributeGroup[$GLOBALS['MAGENTO_EDITION']][$GLOBALS['MAGENTO_VERSION']]);
        $this->persister->flush();
        
        $attributeGroupUpdated = array(
            'ce' => array(
                '1.9' => array(
                    array(
                        'attribute_group_id' => 1,
                        'attribute_set_id' => 1,
                        'attribute_group_name' => 'Updated',
                        'sort_order' => 1,
                        'default_id' => 1,
                    ),
                    array(
                        'attribute_group_id' => 2,
                        'attribute_set_id' => 2,
                        'attribute_group_name' => 'General',
                        'sort_order' => 1,
                        'default_id' => 1,
                    ),
                ),
                '2.0' => array(
                    array(
                        'attribute_group_id' => 1,
                        'attribute_set_id' => 1,
                        'attribute_group_name' => 'Updated',
                        'sort_order' => 1,
                        'default_id' => 1,
                        'attribute_group_code' => 'updated',
                        'tab_group_code' => null
                    ),
                    array(
                        'attribute_group_id' => 2,
                        'attribute_set_id' => 2,
                        'attribute_group_name' => 'General',
                        'sort_order' => 1,
                        'default_id' => 1,
                        'attribute_group_code' => 'general',
                        'tab_group_code' => null
                    ),
                )
            )
        );

        $expected = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet(array('eav_attribute_group' => $attributeGroupUpdated[$GLOBALS['MAGENTO_EDITION']][$GLOBALS['MAGENTO_VERSION']]));

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_group');

        $this->assertDataSetsEqual($expected, $actual);
    }
}
