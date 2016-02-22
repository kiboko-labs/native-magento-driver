<?php

namespace Luni\Component\MagentoDriver\Persister\Product;

use Luni\Component\MagentoDriver\Persister\BaseCsvPersisterTrait;
use Luni\Component\MagentoDriver\Entity\Product\ProductInterface;

class SimpleProductPersister
    implements ProductPersisterInterface
{
    use BaseCsvPersisterTrait;

    public function initialize()
    {
    }

    public function persist(ProductInterface $product)
    {
        if ($product->getId() === null) {
            $this->productQueue->enqueue($product);
        }

        $this->temporaryWriter->persistRow([
            'value_id'         => $product->getId(),
            'entity_type_id'   => 4,
            'attribute_set_id' => $product->getFamilyId(),
            'type_id'          => $product->getType(),
            'sku'              => $product->getIdentifier(),
            'has_options'      => $product->hasOptions(),
            'required_options' => $product->getRequiredOptions(),
            'created_at'       => $product->getCreationDate()->format(\DateTime::ISO8601),
            'updated_at'       => $product->getModificationDate()->format(\DateTime::ISO8601),
        ]);
    }

    public function __invoke(ProductInterface $product)
    {
        $this->persist($product);
    }

    public function flush()
    {
        $this->doFlush();
    }
}