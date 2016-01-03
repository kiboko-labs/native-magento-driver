<?php

namespace Luni\Component\MagentoDriver\Persister\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Persister\AttributeValue\AttributeValuePersisterInterface;
use Luni\Component\MagentoDriver\Entity\ProductInterface;

class StandardProductAttributeValuesPersister
    implements PersisterInterface
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
     * @param array $attributeList
     */
    public function __construct(
        AttributeValuePersisterInterface $persister,
        array $attributeList
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
                $this->attributeValuesPersister->persist($product, $attributeValue);
            }
        }
    }

    /**
     *
     */
    public function flush()
    {
        $this->attributeValuesPersister->flush();
    }
}