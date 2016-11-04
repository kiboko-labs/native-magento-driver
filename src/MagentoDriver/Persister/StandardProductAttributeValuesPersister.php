<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Persister;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;

class StandardProductAttributeValuesPersister implements ProductPersisterInterface
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
     * @param \Traversable                       $attributeList
     */
    public function __construct(
        AttributeValuePersisterInterface $persister,
        \Traversable $attributeList
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
     * @return \Traversable
     */
    public function flush()
    {
        $this->attributeValuesPersister->flush();
    }
}
