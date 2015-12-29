<?php

namespace Luni\Component\MagentoDriver\Backend\Product;

use Luni\Component\MagentoDriver\Backend\BaseCsvBackendTrait;
use Luni\Component\MagentoDriver\Entity\ProductInterface;

class SimpleProductBackend
    implements BackendInterface
{
    use BaseCsvBackendTrait;

    public function initialize()
    {
    }

    public function persist(ProductInterface $product)
    {
        $this->temporaryWriter->persistRow([
            'value_id'         => $product->getId(),
            'entity_type_id'   => 4,
            'attribute_set_id' => $product->getFamily()->getId(),
            'type_id'          => $product->getType(),
            'sku'              => $product->getIdentifier(),
            'has_options'      => $product->hasOptions(),
            'required_options' => $product->getRequiredOptions(),
            'created_at'       => $product->getCreationDate(),
            'updated_at'       => $product->getModificationDate(),
        ]);
    }
}