<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoMapper\Transformer\Magento19\Attribute;

use Kiboko\Component\MagentoDriver\Model\CatalogAttributeExtensionInterface as KibokoCatalogAttributeExtensionInterface;
use Kiboko\Component\MagentoDriver\Model\Magento19\CatalogAttributeExtension;
use Kiboko\Component\MagentoMapper\Transformer\Attribute\AbstractCatalogAttributeExtensionsTransformer;
use Pim\Component\Catalog\Model\AttributeInterface as PimAttributeInterface;

class CatalogAttributeExtensionsTransformer extends AbstractCatalogAttributeExtensionsTransformer
{
    /**
     * @param PimAttributeInterface $attribute
     *
     * @return KibokoCatalogAttributeExtensionInterface[]
     */
    public function transform(PimAttributeInterface $attribute)
    {
        return [
            new CatalogAttributeExtension(
                $frontendInputRendererClassName,
                $global,
                $visible,
                $searchable,
                $filterable,
                $comparable,
                $visibleOnFront,
                $htmlAllowedOnFront,
                $usedForPriceRules,
                $filterableInSearch,
                $usedInProductListing,
                $usedForSortBy,
                $configurable,
                $visibleInAdvancedSearch,
                $wysiwygEnabled,
                $usedForPromoRules,
                $productTypesApplyingTo = [],
                $note = null,
                $position = null
            ),
        ];
    }
}
