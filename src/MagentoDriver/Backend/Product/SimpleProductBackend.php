<?php

namespace Luni\Component\MagentoDriver\Backend\Product;

use Luni\Component\MagentoDriver\Backend\BaseCsvBackendTrait;
use Luni\Component\MagentoDriver\Entity\ProductInterface;

class SimpleProductBackend
    implements BackendInterface
{
    use BaseCsvBackendTrait;

    public function persist(ProductInterface $product)
    {
        $this->temporaryWriter->persistRow([
            'value_id'       => $product->getId(),
            'entity_type_id' => 4,
            'attribute_id'   => $value->getAttributeId(),
            'store_id'       => $value->getStoreId(),
            'entity_id'      => $product->getId(),
            'value'          => $value->getValue()->format('Y-m-d H:i:s'),
        ]);
    }
}