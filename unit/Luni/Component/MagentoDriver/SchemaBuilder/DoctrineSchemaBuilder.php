<?php

namespace unit\Luni\Component\MagentoDriver\SchemaBuilder;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;

class DoctrineSchemaBuilder
{

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

    /**
     * @return \Doctrine\DBAL\Schema\Table
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureStoreTable()
    {
        return (new Table\Store($this->schema))->build();
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
        return (new Table\AttributeGroup($this->schema))->build();
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
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateStoreTable($magentoVersion, $magentoEdition)
    {
        (new Fixture\Loader($this->connection, 'core_store'))
                ->hydrate($magentoVersion, $magentoEdition)
        ;
    }

    /**
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateEntityTypeTable($magentoVersion, $magentoEdition)
    {
        (new Fixture\Loader($this->connection, 'eav_entity_type'))
                ->hydrate($magentoVersion, $magentoEdition)
        ;
    }

    /**
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateEntityStoreTable($magentoVersion, $magentoEdition)
    {
        (new Fixture\Loader($this->connection, 'eav_entity_store'))
                ->hydrate($magentoVersion, $magentoEdition)
        ;
    }
    
    /**
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateEntityAttributeTable($magentoVersion, $magentoEdition)
    {
        (new Fixture\Loader($this->connection, 'eav_entity_attribute'))
                ->hydrate($magentoVersion, $magentoEdition)
        ;
    }

    /**
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateFamilyTable($magentoVersion, $magentoEdition)
    {
        (new Fixture\Loader($this->connection, 'eav_attribute_set'))
                ->hydrate($magentoVersion, $magentoEdition)
        ;
    }

    /**
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateAttributeTable($magentoVersion, $magentoEdition)
    {
        (new Fixture\Loader($this->connection, 'eav_attribute'))
                ->hydrate($magentoVersion, $magentoEdition)
        ;
    }
    
    /**
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateAttributeGroupTable($magentoVersion, $magentoEdition)
    {
        (new Fixture\Loader($this->connection, 'eav_attribute_group'))
                ->hydrate($magentoVersion, $magentoEdition)
        ;
    }
    
    /**
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateAttributeLabelTable($magentoVersion, $magentoEdition)
    {
        (new Fixture\Loader($this->connection, 'eav_attribute_label'))
                ->hydrate($magentoVersion, $magentoEdition)
        ;
    }
    
    /**
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateAttributeOptionTable($magentoVersion, $magentoEdition)
    {
        (new Fixture\Loader($this->connection, 'eav_attribute_option'))
                ->hydrate($magentoVersion, $magentoEdition)
        ;
    }
    
    /**
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateAttributeOptionValueTable($magentoVersion, $magentoEdition)
    {
        (new Fixture\Loader($this->connection, 'eav_attribute_option_value'))
                ->hydrate($magentoVersion, $magentoEdition)
        ;
    }

    /**
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateCatalogAttributeExtensionsTable($magentoVersion, $magentoEdition)
    {
        (new Fixture\Loader($this->connection, 'catalog_eav_attribute'))
                ->hydrate($magentoVersion, $magentoEdition)
        ;
    }

    /**
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateCatalogProductEntityTable($magentoVersion, $magentoEdition)
    {
        (new Fixture\Loader($this->connection, 'catalog_product_entity'))
                ->hydrate($magentoVersion, $magentoEdition)
        ;
    }

    /**
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function hydrateCatalogProductAttributeValueTable($backendType, $magentoVersion, $magentoEdition)
    {
        (new Fixture\Loader($this->connection, sprintf('catalog_product_entity_%s', $backendType)))
                ->hydrate($magentoVersion, $magentoEdition)
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
