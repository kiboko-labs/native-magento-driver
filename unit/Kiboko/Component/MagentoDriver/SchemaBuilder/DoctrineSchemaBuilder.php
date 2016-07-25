<?php

namespace unit\Kiboko\Component\MagentoDriver\SchemaBuilder;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\FallbackResolver;

class DoctrineSchemaBuilder
{
    const CONTEXT_PERSISTER  = 'persister';
    const CONTEXT_DELETER    = 'deleter';
    const CONTEXT_REPOSITORY = 'repository';

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * SchemaBuilder constructor.
     *
     * @param Connection $connection
     * @param Schema     $schema
     */
    public function __construct(Connection $connection, Schema $schema)
    {
        $this->connection = $connection;
        $this->schema = $schema;
    }

    public function getFixturesPath()
    {
        return __DIR__ . '/..';
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureStoreTable()
    {
        return (new Table\Store($this->schema))->build($GLOBALS['MAGENTO_VERSION']);
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureEntityTypeTable()
    {
        return (new Table\EntityType($this->schema))->build();
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureEntityStoreTable()
    {
        return (new Table\EntityStore($this->schema))->build();
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureFamilyTable()
    {
        return (new Table\Family($this->schema))->build();
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureAttributeTable()
    {
        return (new Table\Attribute($this->schema))->build();
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureEntityAttributeTable()
    {
        return (new Table\EntityAttribute($this->schema))->build();
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureAttributeGroupTable()
    {
        return (new Table\AttributeGroup($this->schema))->build($GLOBALS['MAGENTO_VERSION']);
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureAttributeLabelTable()
    {
        return (new Table\AttributeLabel($this->schema))->build();
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureAttributeOptionTable()
    {
        return (new Table\AttributeOption($this->schema))->build();
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureAttributeOptionValueTable()
    {
        return (new Table\AttributeOptionValue($this->schema))->build();
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogAttributeExtensionsTable()
    {
        return (new Table\CatalogAttributeExtension($this->schema))->build();
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogProductEntityTable()
    {
        return (new Table\CatalogProductEntity($this->schema))->build();
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogCategoryEntityTable()
    {
        return (new Table\CatalogCategoryEntity($this->schema))->build();
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogCategoryProductIndexTable()
    {
        return (new Table\CatalogCategoryProductIndex($this->schema))->build();
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogCategoryProductTable()
    {
        return (new Table\CatalogCategoryProduct($this->schema))->build();
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogProductLinkTable()
    {
        return (new Table\CatalogProductLink($this->schema))->build();
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogProductSuperAttributeTable()
    {
        return (new Table\CatalogProductSuperAttribute($this->schema))->build();
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogProductLinkTypeTable()
    {
        return (new Table\CatalogProductLinkType($this->schema))->build();
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogProductLinkAttributeTable()
    {
        return (new Table\CatalogProductLinkAttribute($this->schema))->build();
    }

    /**
     * @param string $backendName
     * @param string $backendType
     * @param array  $backendOptions
     *
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogProductLinkAttributeValueTable($backendName, $backendType, array $backendOptions = [])
    {
        return (new Table\CatalogProductLinkAttributeValue($this->schema, $backendType, $backendName, $backendOptions))->build();
    }

    /**
     * @param string $backendName
     * @param string $backendType
     * @param array  $backendOptions
     *
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogProductAttributeValueTable($backendName, $backendType, array $backendOptions = [])
    {
        return (new Table\CatalogProductAttributeValue($this->schema, $backendType, $backendName, $backendOptions))->build();
    }

    /**
     * @param string $backendName
     * @param string $backendType
     * @param array  $backendOptions
     *
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogCategoryAttributeValueTable($backendName, $backendType, array $backendOptions = [])
    {
        return (new Table\CatalogCategoryAttributeValue($this->schema, $backendType, $backendName, $backendOptions))->build();
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogProductGalleryTable()
    {
        return (new Table\CatalogProductGallery($this->schema))->build();
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogProductMediaGalleryTable()
    {
        return (new Table\CatalogProductMediaGallery($this->schema))->build();
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogProductMediaGalleryAttributeValueTable()
    {
        return (new Table\CatalogProductMediaGalleryAttributeValue($this->schema))->build();
    }

    /**
     * @param string $suite
     * @param string $context
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateStoreTable($suite, $context, $magentoVersion, $magentoEdition)
    {
        $resolver = new FallbackResolver($this->getFixturesPath());
        (new Fixture\Hydrator($this->connection, $resolver, $magentoVersion, $magentoEdition))
            ->hydrate(Table\Store::getTableName($magentoVersion), $suite, $context)
        ;
    }

    /**
     * @param string $suite
     * @param string $context
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateEntityTypeTable($suite, $context, $magentoVersion, $magentoEdition)
    {
        $resolver = new FallbackResolver($this->getFixturesPath());
        (new Fixture\Hydrator($this->connection, $resolver, $magentoVersion, $magentoEdition))
            ->hydrate('eav_entity_type', $suite, $context)
        ;
    }

    /**
     * @param string $suite
     * @param string $context
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateEntityStoreTable($suite, $context, $magentoVersion, $magentoEdition)
    {
        $resolver = new FallbackResolver($this->getFixturesPath());
        (new Fixture\Hydrator($this->connection, $resolver, $magentoVersion, $magentoEdition))
            ->hydrate('eav_entity_store', $suite, $context)
        ;
    }

    /**
     * @param string $suite
     * @param string $context
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateEntityAttributeTable($suite, $context, $magentoVersion, $magentoEdition)
    {
        $resolver = new FallbackResolver($this->getFixturesPath());
        (new Fixture\Hydrator($this->connection, $resolver, $magentoVersion, $magentoEdition))
            ->hydrate('eav_entity_attribute', $suite, $context)
        ;
    }

    /**
     * @param string $suite
     * @param string $context
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateFamilyTable($suite, $context, $magentoVersion, $magentoEdition)
    {
        $resolver = new FallbackResolver($this->getFixturesPath());
        (new Fixture\Hydrator($this->connection, $resolver, $magentoVersion, $magentoEdition))
            ->hydrate('eav_attribute_set', $suite, $context)
        ;
    }

    /**
     * @param string $suite
     * @param string $context
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateAttributeTable($suite, $context, $magentoVersion, $magentoEdition)
    {
        $resolver = new FallbackResolver($this->getFixturesPath());
        (new Fixture\Hydrator($this->connection, $resolver, $magentoVersion, $magentoEdition))
            ->hydrate('eav_attribute', $suite, $context)
        ;
    }

    /**
     * @param string $suite
     * @param string $context
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateAttributeGroupTable($suite, $context, $magentoVersion, $magentoEdition)
    {
        $resolver = new FallbackResolver($this->getFixturesPath());
        (new Fixture\Hydrator($this->connection, $resolver, $magentoVersion, $magentoEdition))
            ->hydrate('eav_attribute_group', $suite, $context)
        ;
    }

    /**
     * @param string $suite
     * @param string $context
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateAttributeLabelTable($suite, $context, $magentoVersion, $magentoEdition)
    {
        $resolver = new FallbackResolver($this->getFixturesPath());
        (new Fixture\Hydrator($this->connection, $resolver, $magentoVersion, $magentoEdition))
            ->hydrate('eav_attribute_label', $suite, $context)
        ;
    }

    /**
     * @param string $suite
     * @param string $context
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateAttributeOptionTable($suite, $context, $magentoVersion, $magentoEdition)
    {
        $resolver = new FallbackResolver($this->getFixturesPath());
        (new Fixture\Hydrator($this->connection, $resolver, $magentoVersion, $magentoEdition))
            ->hydrate('eav_attribute_option', $suite, $context)
        ;
    }

    /**
     * @param string $suite
     * @param string $context
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateAttributeOptionValueTable($suite, $context, $magentoVersion, $magentoEdition)
    {
        $resolver = new FallbackResolver($this->getFixturesPath());
        (new Fixture\Hydrator($this->connection, $resolver, $magentoVersion, $magentoEdition))
            ->hydrate('eav_attribute_option_value', $suite, $context)
        ;
    }

    /**
     * @param string $suite
     * @param string $context
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateCatalogAttributeExtensionsTable($suite, $context, $magentoVersion, $magentoEdition)
    {
        $resolver = new FallbackResolver($this->getFixturesPath());
        (new Fixture\Hydrator($this->connection, $resolver, $magentoVersion, $magentoEdition))
            ->hydrate('catalog_eav_attribute', $suite, $context)
        ;
    }

    /**
     * @param string $suite
     * @param string $context
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateCatalogProductEntityTable($suite, $context, $magentoVersion, $magentoEdition)
    {
        $resolver = new FallbackResolver($this->getFixturesPath());
        (new Fixture\Hydrator($this->connection, $resolver, $magentoVersion, $magentoEdition))
            ->hydrate('catalog_product_entity', $suite, $context)
        ;
    }

    /**
     * @param string $backendType
     * @param string $suite
     * @param string $context
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateCatalogProductAttributeValueTable($backendType, $suite, $context, $magentoVersion, $magentoEdition)
    {
        $resolver = new FallbackResolver($this->getFixturesPath());
        (new Fixture\Hydrator($this->connection, $resolver, $magentoVersion, $magentoEdition))
            ->hydrate(sprintf('catalog_product_entity_%s', $backendType), $suite, $context)
        ;
    }

    /**
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureFamilyToEntityTypeLinks()
    {
        (new Link\FamilyToEntityType($this->schema))->build();
    }

    /**
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureAttributeToEntityTypeLinks()
    {
        (new Link\AttributeToEntityType($this->schema))->build();
    }

    /**
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogAttributeExtensionsToAttributeLinks()
    {
        (new Link\CatalogAttributeExtensionToAttribute($this->schema))->build();
    }

    /**
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogProductEntityToFamilyLinks()
    {
        (new Link\CatalogProductEntityToFamily($this->schema))->build();
    }

    /**
     * @param string $backendType
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogProductAttributeValueToEntityTypeLinks($backendType)
    {
        (new Link\CatalogProductAttributeValueToEntityType($this->schema, $backendType))->build();
    }

    /**
     * @param string $backendType
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogProductAttributeValueToAttributeLinks($backendType)
    {
        (new Link\CatalogProductAttributeValueToAttribute($this->schema, $backendType))->build();
    }

    /**
     * @param string $backendType
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogProductAttributeValueToStoreLinks($backendType)
    {
        (new Link\CatalogProductAttributeValueToStore($this->schema, $backendType))->build();
    }

    /**
     * @param string $backendType
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogProductAttributeValueToCatalogProductEntityLinks($backendType)
    {
        (new Link\CatalogProductAttributeValueToCatalogProductEntity($this->schema, $backendType))->build();
    }
}
