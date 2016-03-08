<?php

namespace Luni\Component\MagentoDriver\Persister\Direct\Attribute;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Persister\AttributePersisterInterface;

class ProductAttributePersister
    implements AttributePersisterInterface
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
     * @param AttributeInterface $attribute
     */
    public function persist(AttributeInterface $attribute)
    {
        $this->dataQueue->push($attribute);
    }

    /**
     * @return void
     */
    public function flush()
    {
        foreach ($this->dataQueue as $attribute) {
            if ($attribute->getId()) {
                $this->connection->update($this->tableName,
                    [
                        'frontend_input_renderer'       => $attribute->getOptionOrDefault('frontend_input_renderer'),
                        'is_global'                     => $attribute->getOptionOrDefault('is_global'),
                        'is_visible'                    => $attribute->getOptionOrDefault('is_visible'),
                        'is_searchable'                 => $attribute->getOptionOrDefault('is_searchable'),
                        'is_filterable'                 => $attribute->getOptionOrDefault('is_filterable'),
                        'is_comparable'                 => $attribute->getOptionOrDefault('is_comparable'),
                        'is_visible_on_front'           => $attribute->getOptionOrDefault('is_visible_on_front'),
                        'is_html_allowed_on_front'      => $attribute->getOptionOrDefault('is_html_allowed_on_front'),
                        'is_used_for_price_rules'       => $attribute->getOptionOrDefault('is_used_for_price_rules'),
                        'is_filterable_in_search'       => $attribute->getOptionOrDefault('is_filterable_in_search'),
                        'used_in_product_listing'       => $attribute->getOptionOrDefault('used_in_product_listing'),
                        'used_for_sort_by'              => $attribute->getOptionOrDefault('used_for_sort_by'),
                        'is_configurable'               => $attribute->getOptionOrDefault('is_configurable'),
                        'apply_to'                      => $attribute->getOptionOrDefault('apply_to'),
                        'is_visible_in_advanced_search' => $attribute->getOptionOrDefault('is_visible_in_advanced_search'),
                        'position'                      => $attribute->getOptionOrDefault('position'),
                        'is_wysiwyg_enabled'            => $attribute->getOptionOrDefault('is_wysiwyg_enabled'),
                        'is_used_for_promo_rules'       => $attribute->getOptionOrDefault('is_used_for_promo_rules'),
                    ],
                    [
                        'attribute_id' => $attribute->getId(),
                    ]
                );
            } else {
                $this->connection->insert($this->tableName,
                    [
                        'attribute_id'                  => $attribute->getId(),
                        'frontend_input_renderer'       => $attribute->getOptionOrDefault('frontend_input_renderer'),
                        'is_global'                     => $attribute->getOptionOrDefault('is_global'),
                        'is_visible'                    => $attribute->getOptionOrDefault('is_visible'),
                        'is_searchable'                 => $attribute->getOptionOrDefault('is_searchable'),
                        'is_filterable'                 => $attribute->getOptionOrDefault('is_filterable'),
                        'is_comparable'                 => $attribute->getOptionOrDefault('is_comparable'),
                        'is_visible_on_front'           => $attribute->getOptionOrDefault('is_visible_on_front'),
                        'is_html_allowed_on_front'      => $attribute->getOptionOrDefault('is_html_allowed_on_front'),
                        'is_used_for_price_rules'       => $attribute->getOptionOrDefault('is_used_for_price_rules'),
                        'is_filterable_in_search'       => $attribute->getOptionOrDefault('is_filterable_in_search'),
                        'used_in_product_listing'       => $attribute->getOptionOrDefault('used_in_product_listing'),
                        'used_for_sort_by'              => $attribute->getOptionOrDefault('used_for_sort_by'),
                        'is_configurable'               => $attribute->getOptionOrDefault('is_configurable'),
                        'apply_to'                      => $attribute->getOptionOrDefault('apply_to'),
                        'is_visible_in_advanced_search' => $attribute->getOptionOrDefault('is_visible_in_advanced_search'),
                        'position'                      => $attribute->getOptionOrDefault('position'),
                        'is_wysiwyg_enabled'            => $attribute->getOptionOrDefault('is_wysiwyg_enabled'),
                        'is_used_for_promo_rules'       => $attribute->getOptionOrDefault('is_used_for_promo_rules'),
                    ]
                );

                $attribute->persistedToId($this->connection->lastInsertId());
            }
        }
    }

    /**
     * @param AttributeInterface $attribute
     */
    public function __invoke(AttributeInterface $attribute)
    {
        $this->persist($attribute);
    }
}
