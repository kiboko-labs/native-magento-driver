<?php

namespace unit\Luni\Component\MagentoDriver\Persister\Direct\Attribute;

use Doctrine\DBAL\Schema\Schema;
use Luni\Component\MagentoDriver\Entity\Product\ProductInterface;
use Luni\Component\MagentoDriver\Model\Attribute;
use Luni\Component\MagentoDriver\Model\CatalogAttributeExtension;
use Luni\Component\MagentoDriver\Persister\CatalogAttributeExtensionPersisterInterface;
use Luni\Component\MagentoDriver\Persister\Direct\Attribute\CatalogAttributeExtensionPersister;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilder;
use unit\Luni\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Luni\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Luni\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;

class CatalogAttributeExtensionPersisterTest
    extends \PHPUnit_Framework_TestCase
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

        $this->getConnection()->exec(
            $platform->getTruncateTableSQL('catalog_eav_attribute')
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
        $schemaBuilder->ensureCatalogAttributeExtensionsTable();
        $schemaBuilder->ensureAttributeToEntityTypeLinks();
        $schemaBuilder->ensureCatalogAttributeExtensionsToAttributeLinks();
        $schemaBuilder->hydrateEntityTypeTable('1.9', 'ce');
        $schemaBuilder->hydrateAttributeTable('1.9', 'ce');

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getConnection()->getDatabasePlatform()) as $sql) {
            $this->getConnection()->exec($sql);
        }

        $this->truncateTables();

        $this->persister = new CatalogAttributeExtensionPersister(
            $this->getConnection(),
            ProductAttributeQueryBuilder::getDefaultExtraTable()
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

    public function testInsertOneInteger()
    {
        $dataLoader = new Loader($this->connection, 'catalog_eav_attribute');

        $data = $dataLoader->readData('1.9', 'ce');
        $attribute = new CatalogAttributeExtension(
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

        $this->persister->initialize();
        $this->persister->persist($attribute);
        $this->persister->flush();
    }

    public function testInsertOneSelectable()
    {
        $attribute = new Attribute(
            ProductInterface::ENTITY_TYPE_ID,
            'testing_integer',
            null,
            null,
            'int',
            null,
            null,
            'select',
            null,
            null,
            'eav/entity_attribute_source_table',
            0,
            1,
            null,
            0,
            null
        );

        $this->persister->initialize();
        $this->persister->persist($attribute);
        $this->persister->flush();
    }
}
