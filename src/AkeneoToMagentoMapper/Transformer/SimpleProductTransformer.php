<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Transformer;

use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface as KibokoProductInterface;
use Kiboko\Component\MagentoORM\Entity\Product\SimpleProduct;
use Kiboko\Component\AkeneoToMagentoMapper\Mapper\FamilyMapperInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Mapper\ProductMapperInterface;
use Pim\Component\Catalog\Model\ProductInterface as PimProductInterface;

class SimpleProductTransformer implements ProductTransformerInterface
{
    /**
     * @var ProductMapperInterface
     */
    private $productMapper;

    /**
     * @var FamilyMapperInterface
     */
    private $familyMapper;

    /**
     * @param PimProductInterface $product
     *
     * @return KibokoProductInterface|null
     */
    public function transform(PimProductInterface $product)
    {
        return [
            SimpleProduct::buildNewWith(
                $this->productMapper->map($product->getId()),
                $product->getIdentifier(),
                $this->familyMapper->map($product->getFamily()->getCode()),
                new \DateTimeImmutable(),
                new \DateTimeImmutable()
            ),
        ];
    }

    /**
     * @param PimProductInterface $product
     *
     * @return bool
     */
    public function supportsTransformation(PimProductInterface $product)
    {
        return false;
    }
}
