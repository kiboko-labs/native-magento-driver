<?php

namespace Luni\Component\MagentoDriver\Persister\FlatFile\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Persister\AttributeValuePersisterInterface;
use Luni\Component\MagentoDriver\Entity\Product\ProductInterface;
use Luni\Component\MagentoDriver\Persister\ProductPersisterInterface;

class StandardProductAttributeValuesPersister
    implements ProductPersisterInterface
{
    /**
     * @var AttributeValuePersisterInterface
     */
    private $attributeValuesPersister;

    /**
     * @var Collection|AttributeInterface[]
     */
    private $attributeList;

    /**
     * @param AttributeValuePersisterInterface $persister
     * @param Collection $attributeList
     */
    public function __construct(
        AttributeValuePersisterInterface $persister,
        Collection $attributeList
    ) {
        $this->attributeValuesPersister = $persister;

        $this->attributeList = new ArrayCollection();
        foreach ($attributeList as $attribute) {
            if (!$attribute instanceof AttributeInterface) {
                continue;
            }

            $this->attributeList->add($attribute);
        }
    }

    /**
     *
     */
    public function initialize()
    {
        $this->attributeValuesPersister->initialize();
    }

    /**
     * @param ProductInterface $product
     */
    public function persist(ProductInterface $product)
    {
        foreach ($this->attributeList as $attribute) {
            foreach ($product->getAllValuesFor($attribute) as $attributeValue) {
                $this->attributeValuesPersister->persist($attributeValue);
            }
        }
    }

    /**
     * @param ProductInterface $product
     */
    public function __invoke(ProductInterface $product)
    {
        $this->persist($product);
    }

    /**
     *
     */
    public function flush()
    {
        $this->attributeValuesPersister->flush();
    }
}