<?php

namespace Luni\Component\MagentoDriver\Persister\Direct\Attribute;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Model\CatalogAttributeExtensionInterface;
use Luni\Component\MagentoDriver\Persister\CatalogAttributeExtensionPersisterInterface;

class CatalogAttributeExtensionPersister
    implements CatalogAttributeExtensionPersisterInterface
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var string
     */
    private $tableName;

    /**
     * @var \SplQueue
     */
    private $dataQueue;

    /**
     * @param Connection $connection
     * @param string $tableName
     */
    public function __construct(
        Connection $connection,
        $tableName
    ) {
        $this->connection = $connection;
        $this->tableName = $tableName;
        $this->dataQueue = new \SplQueue();
    }

    /**
     * @return string
     */
    protected function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @return void
     */
    public function initialize()
    {
        $this->dataQueue = new \SplQueue();
    }

    /**
     * @param CatalogAttributeExtensionInterface $attribute
     */
    public function persist(CatalogAttributeExtensionInterface $attribute)
    {
        $this->dataQueue->push($attribute);
    }

    /**
     * @return void
     */
    public function flush()
    {
        /** @var CatalogAttributeExtensionInterface $attribute */
        foreach ($this->dataQueue as $attribute) {
            if ($attribute->getId()) {
                $this->connection->update($this->tableName,
                    [
                        'frontend_input_renderer'       => $attribute->getFrontendInputRendererClassName(),
                        'is_global'                     => $attribute->isGlobal(),
                        'is_visible'                    => $attribute->isVisible(),
                        'is_searchable'                 => $attribute->isSearchable(),
                        'is_filterable'                 => $attribute->isFilterable(),
                        'is_comparable'                 => $attribute->isComparable(),
                        'is_visible_on_front'           => $attribute->isVisibleOnFront(),
                        'is_html_allowed_on_front'      => $attribute->isHtmlAllowedOnFront(),
                        'is_used_for_price_rules'       => $attribute->isUsedForPriceRules(),
                        'is_filterable_in_search'       => $attribute->isFilterableInSearch(),
                        'used_in_product_listing'       => $attribute->isUsedInProductListing(),
                        'used_for_sort_by'              => $attribute->isUsedForSortBy(),
                        'is_configurable'               => $attribute->isConfigurable(),
                        'apply_to'                      => implode(',', $attribute->getProductTypesApplyingTo()),
                        'is_visible_in_advanced_search' => $attribute->isVisibleInAdvancedSearch(),
                        'position'                      => $attribute->getPosition(),
                        'is_wysiwyg_enabled'            => $attribute->isWysiwygEnabled(),
                        'is_used_for_promo_rules'       => $attribute->isUsedForPromoRules(),
                    ],
                    [
                        'attribute_id' => $attribute->getId(),
                    ]
                );
            } else {
                $this->connection->insert($this->tableName,
                    [
                        'frontend_input_renderer'       => $attribute->getFrontendInputRendererClassName(),
                        'is_global'                     => $attribute->isGlobal(),
                        'is_visible'                    => $attribute->isVisible(),
                        'is_searchable'                 => $attribute->isSearchable(),
                        'is_filterable'                 => $attribute->isFilterable(),
                        'is_comparable'                 => $attribute->isComparable(),
                        'is_visible_on_front'           => $attribute->isVisibleOnFront(),
                        'is_html_allowed_on_front'      => $attribute->isHtmlAllowedOnFront(),
                        'is_used_for_price_rules'       => $attribute->isUsedForPriceRules(),
                        'is_filterable_in_search'       => $attribute->isFilterableInSearch(),
                        'used_in_product_listing'       => $attribute->isUsedInProductListing(),
                        'used_for_sort_by'              => $attribute->isUsedForSortBy(),
                        'is_configurable'               => $attribute->isConfigurable(),
                        'apply_to'                      => implode(',', $attribute->getProductTypesApplyingTo()),
                        'is_visible_in_advanced_search' => $attribute->isVisibleInAdvancedSearch(),
                        'position'                      => $attribute->getPosition(),
                        'is_wysiwyg_enabled'            => $attribute->isWysiwygEnabled(),
                        'is_used_for_promo_rules'       => $attribute->isUsedForPromoRules(),
                    ]
                );

                $attribute->persistedToId($this->connection->lastInsertId());
            }
        }
    }

    /**
     * @param CatalogAttributeExtensionInterface $attribute
     */
    public function __invoke(CatalogAttributeExtensionInterface $attribute)
    {
        $this->persist($attribute);
    }
}