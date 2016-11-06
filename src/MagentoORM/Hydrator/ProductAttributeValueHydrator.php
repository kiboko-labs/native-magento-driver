<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Hydrator;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoORM\Exception\InvalidArgumentException;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Model\AttributeValueInterface;
use Kiboko\Component\MagentoORM\Repository\ProductAttributeValueRepositoryInterface;

class ProductAttributeValueHydrator implements ProductAttributeValueHydratorInterface
{
    /**
     * @var ProductAttributeValueRepositoryInterface
     */
    private $attributeValueRepository;

    /**
     * @param ProductAttributeValueRepositoryInterface $attributeValueRepository
     */
    public function __construct(
        ProductAttributeValueRepositoryInterface $attributeValueRepository
    ) {
        $this->attributeValueRepository = $attributeValueRepository;
    }

    /**
     * @param ProductInterface $product
     * @param int              $storeId
     */
    public function hydrate(ProductInterface $product, $storeId = null)
    {
        /** @var Collection $attributeValuesList */
        $attributeValuesList = $this->attributeValueRepository
            ->findAllByProductFromStoreId($product, 1);

        foreach ($attributeValuesList as $attributeValue) {
            $product->setValue($attributeValue);
        }
    }

    /**
     * @param ProductInterface     $product
     * @param AttributeInterface[] $attributeList
     * @param int                  $storeId
     */
    public function hydrateByAttributeList(ProductInterface $product, array $attributeList, $storeId = null)
    {
        /** @var Collection $attributeValuesList */
        $attributeValuesList = $this->attributeValueRepository
            ->findAllByProductAndAttributeListFromStoreId($product, $attributeList, $storeId);

        foreach ($attributeValuesList as $attributeValue) {
            $product->setValue($attributeValue);
        }
    }

    /**
     * @param ProductInterface[] $productList
     *
     * @return Collection|ProductInterface[]
     */
    private function transformListToCollection(array $productList)
    {
        $productCollection = new ArrayCollection();
        /** @var ProductInterface $product */
        foreach ($productList as $product) {
            if (!$product instanceof ProductInterface) {
                throw new InvalidArgumentException(sprintf('Passed array elements should be %s instances, %s found.',
                    ProductInterface::class, is_object($product) ? get_class($product) : gettype($product)));
            }

            $productCollection->set($product->getId(), $product);
        }

        return $productCollection;
    }

    /**
     * @param ProductInterface[] $productList
     * @param int                $storeId
     */
    public function hydrateList(array $productList, $storeId = null)
    {
        /** @var Collection $attributeValuesList */
        $attributeValuesList = $this->attributeValueRepository
            ->findAllByProductListFromStoreId($productList, $storeId);

        $productCollection = $this->transformListToCollection($productList);
        /** @var AttributeValueInterface $attributeValue */
        foreach ($attributeValuesList as $attributeValue) {
            if (!$productCollection->containsKey($attributeValue->getProductId())) {
                continue;
            }

            /** @var ProductInterface $product */
            $product = $productCollection->get($attributeValue->getProductId());
            $product->setValue($attributeValue);
        }
    }

    /**
     * @param ProductInterface[]   $productList
     * @param AttributeInterface[] $attributeList
     * @param int                  $storeId
     */
    public function hydrateListByAttributeList(array $productList, array $attributeList, $storeId = null)
    {
        /** @var Collection $attributeValuesList */
        $attributeValuesList = $this->attributeValueRepository
            ->findAllByProductListAndAttributeListFromStoreId($productList, $attributeList, $storeId);

        $productCollection = $this->transformListToCollection($productList);
        /** @var AttributeValueInterface $attributeValue */
        foreach ($attributeValuesList as $attributeValue) {
            if (!$productCollection->containsKey($attributeValue->getProductId())) {
                continue;
            }

            /** @var ProductInterface $product */
            $product = $productCollection->get($attributeValue->getProductId());
            $product->setValue($attributeValue);
        }
    }
}
