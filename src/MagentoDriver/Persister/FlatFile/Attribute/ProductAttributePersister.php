<?php

namespace Luni\Component\MagentoDriver\Persister\FlatFile\Attribute;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Persister\AttributePersisterInterface;
use Luni\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Luni\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;

class ProductAttributePersister
    implements AttributePersisterInterface
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
     * @param TemporaryWriterInterface $extendedTemporaryWriter
     * @param DatabaseWriterInterface $extendedTableDatabaseWriter
     * @param string $extendedTableName
     * @param array $extendedTableKeys
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
