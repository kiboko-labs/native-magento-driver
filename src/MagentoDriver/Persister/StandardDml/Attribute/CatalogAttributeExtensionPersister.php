<?php

namespace Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Exception\RuntimeErrorException;
use Kiboko\Component\MagentoDriver\Model\CatalogAttributeExtensionInterface;
use Kiboko\Component\MagentoDriver\Persister\CatalogAttributeExtensionPersisterInterface;

class CatalogAttributeExtensionPersister implements CatalogAttributeExtensionPersisterInterface
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
     * @param string     $tableName
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

    public function flush()
    {
        /** @var CatalogAttributeExtensionInterface $attribute */
        foreach ($this->dataQueue as $attribute) {
            if (!$attribute->getId()) {
                throw new RuntimeErrorException('Attribute #id should be defined.');
            }

            $count = $this->connection->update($this->tableName,
                [
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
                ],
                [
                    'attribute_id' => $attribute->getId(),
                ]
            );

            if ($count <= 0) {
                $this->connection->insert($this->tableName,
                    [
                        'attribute_id' => $attribute->getId(),
                        'frontend_input_renderer' => $attribute->getFrontendInputRendererClassName(),
                        'is_global' => $attribute->isGlobal(),
                        'is_visible' => (int) $attribute->isVisible(),
                        'is_searchable' => (int) $attribute->isSearchable(),
                        'is_filterable' => (int) $attribute->isFilterable(),
                        'is_comparable' => (int) $attribute->isComparable(),
                        'is_visible_on_front' => (int) $attribute->isVisibleOnFront(),
                        'is_html_allowed_on_front' => (int) $attribute->isHtmlAllowedOnFront(),
                        'is_used_for_price_rules' => (int) $attribute->isUsedForPriceRules(),
                        'is_filterable_in_search' => (int) $attribute->isFilterableInSearch(),
                        'used_in_product_listing' => (int) $attribute->isUsedInProductListing(),
                        'used_for_sort_by' => (int) $attribute->isUsedForSortBy(),
                        'is_configurable' => (int) $attribute->isConfigurable(),
                        'apply_to' => empty($attribute->getProductTypesApplyingTo()) ?
                            null : implode(',', $attribute->getProductTypesApplyingTo()),
                        'is_visible_in_advanced_search' => (int) $attribute->isVisibleInAdvancedSearch(),
                        'position' => $attribute->getPosition(),
                        'is_wysiwyg_enabled' => (int) $attribute->isWysiwygEnabled(),
                        'is_used_for_promo_rules' => (int) $attribute->isUsedForPromoRules(),
                    ]
                );
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
