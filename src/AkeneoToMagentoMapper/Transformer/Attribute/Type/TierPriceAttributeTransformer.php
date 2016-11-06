<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Transformer\Attribute\Type;

use Kiboko\Component\MagentoORM\Model\Attribute;
use Kiboko\Component\MagentoORM\Model\AttributeInterface as KibokoAttributeInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Mapper\EntityTypeMapperInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Transformer\AttributeTransformerInterface;
use Pim\Component\Catalog\Model\AttributeInterface as PimAttributeInterface;

/**
 * Class TierPriceAttributeTransformer.
 *
 * @attributes msrp_display_actual_price_type
 */
class TierPriceAttributeTransformer implements AttributeTransformerInterface
{
    /**
     * @var EntityTypeMapperInterface
     */
    private $entityTypeMapper;

    /**
     * @var string[]
     */
    private $supportedAttributeCodes;

    /**
     * @param EntityTypeMapperInterface $entityTypeMapper
     * @param string[]
     */
    public function __construct(
        EntityTypeMapperInterface $entityTypeMapper,
        array $supportedAttributeCodes = null
    ) {
        $this->entityTypeMapper = $entityTypeMapper;

        if ($supportedAttributeCodes === null) {
            $this->supportedAttributeCodes = [
                'msrp_display_actual_price_type',
            ];
        } else {
            $this->supportedAttributeCodes = $supportedAttributeCodes;
        }
    }

    /**
     * @param PimAttributeInterface $attribute
     * @param int|null              $mappedId
     *
     * @return KibokoAttributeInterface[]
     */
    public function transform(PimAttributeInterface $attribute, $mappedId = null)
    {
        return [
            Attribute::buildNewWith(
                $mappedId,                                          // attribute_id
                $this->entityTypeMapper->map($attribute),           // entity_type_id
                $attribute->getCode(),                              // attribute_code
                null,                                               // attribute_model
                'decimal',                                          // backend_type
                'catalog/product_attribute_backend_tierprice',      // backend_model
                null,                                               // backend_table
                null,                                               // frontend_model
                'text',                                             // frontend_input
// TODO: check the following values
                $attribute->getLabel(),                             // frontend_label
                null,                                               // frontend_class
                'catalog/product_attribute_source_msrp_type_price', // source_model
                $attribute->isRequired(),                           // is_required
                true,                                               // is_user_defined
                $attribute->isUnique(),                             // is_unique
                null,                                               // default_value
                null                                                // note
            ),
        ];
    }

    /**
     * @param PimAttributeInterface $attribute
     *
     * @return bool
     */
    public function supportsTransformation(PimAttributeInterface $attribute)
    {
        return $attribute->getAttributeType() === 'pim_catalog_boolean'
            && in_array($attribute->getCode(), $this->supportedAttributeCodes);
    }
}
