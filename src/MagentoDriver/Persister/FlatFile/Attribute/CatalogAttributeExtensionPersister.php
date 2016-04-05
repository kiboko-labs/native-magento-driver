<?php

namespace Luni\Component\MagentoDriver\Persister\FlatFile\Attribute;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Persister\AttributePersisterInterface;
use Luni\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Luni\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;

class CatalogAttributeExtensionPersister implements AttributePersisterInterface
{
    /**
     * @var AttributePersisterInterface
     */
    protected $baseAttributePersister;

    /**
     * @var TemporaryWriterInterface
     */
    private $extendedTableTemporaryWriter;

    /**
     * @var DatabaseWriterInterface
     */
    private $extendedTableDatabaseWriter;

    /**
     * @var string
     */
    private $extendedTableName;

    /**
     * @var array
     */
    private $extendedTableKeys;

    /**
     * @param AttributePersisterInterface $baseAttributePersister
     * @param TemporaryWriterInterface    $extendedTemporaryWriter
     * @param DatabaseWriterInterface     $extendedTableDatabaseWriter
     * @param string                      $extendedTableName
     * @param array                       $extendedTableKeys
     */
    public function __construct(
        AttributePersisterInterface $baseAttributePersister,
        TemporaryWriterInterface $extendedTemporaryWriter,
        DatabaseWriterInterface $extendedTableDatabaseWriter,
        $extendedTableName,
        array $extendedTableKeys = []
    ) {
        $this->baseAttributePersister = $baseAttributePersister;
        $this->extendedTemporaryWriter = $extendedTemporaryWriter;
        $this->extendedTableDatabaseWriter = $extendedTableDatabaseWriter;
        $this->extendedTableName = $extendedTableName;
        $this->extendedTableKeys = $extendedTableKeys;
    }

    /**
     * @return string
     */
    protected function getExtendedTableName()
    {
        return $this->extendedTableName;
    }

    /**
     * @return array
     */
    protected function getExtendedTableKeys()
    {
        return $this->extendedTableKeys;
    }

    public function initialize()
    {
        $this->baseAttributePersister->initialize();
    }

    public function persist(AttributeInterface $attribute)
    {
        $this->baseAttributePersister->persist($attribute);

        $this->extendedTemporaryWriter->persistRow([
            'attribute_id' => $attribute->getId(),
            'frontend_input_renderer' => $attribute->getFrontendInputRendererClassName(),
            'is_global' => $attribute->isGlobal(),
            'is_visible' => $attribute->isVisible(),
            'is_searchable' => $attribute->isSearchable(),
            'is_filterable' => $attribute->isFilterable(),
            'is_comparable' => $attribute->isComparable(),
            'is_visible_on_front' => $attribute->isVisibleOnFront(),
            'is_html_allowed_on_front' => $attribute->isHtmlAllowedOnFront(),
            'is_used_for_price_rules' => $attribute->isUsedForPriceRules(),
            'is_filterable_in_search' => $attribute->isFilterableInSearch(),
            'used_in_product_listing' => $attribute->isUsedInProductListing(),
            'used_for_sort_by' => $attribute->isUsedForSortBy(),
            'is_configurable' => $attribute->isConfigurable(),
            'apply_to' => empty($attribute->getProductTypesApplyingTo()) ?
                null : implode(',', $attribute->getProductTypesApplyingTo()),
            'is_visible_in_advanced_search' => $attribute->isVisibleInAdvancedSearch(),
            'position' => $attribute->getPosition(),
            'is_wysiwyg_enabled' => $attribute->isWysiwygEnabled(),
            'is_used_for_promo_rules' => $attribute->isUsedForPromoRules(),
        ]);
    }

    public function flush()
    {
        $this->baseAttributePersister->flush();

        $this->extendedTableTemporaryWriter->flush();
        $this->extendedTableDatabaseWriter->write($this->getExtendedTableName(), $this->getExtendedTableKeys());
    }

    public function __invoke(AttributeInterface $attribute)
    {
        $this->persist($attribute);
    }
}
