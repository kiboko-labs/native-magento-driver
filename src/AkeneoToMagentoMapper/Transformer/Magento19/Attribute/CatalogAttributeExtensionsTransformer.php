<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Transformer\V1_9ce\Attribute;

use Kiboko\Component\MagentoORM\Model\CatalogAttributeExtensionInterface as KibokoCatalogAttributeExtensionInterface;
use Kiboko\Component\MagentoORM\Model\V1_9ce\CatalogAttributeExtension;
use Kiboko\Component\AkeneoToMagentoMapper\Transformer\Attribute\AbstractCatalogAttributeExtensionsTransformer;
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
