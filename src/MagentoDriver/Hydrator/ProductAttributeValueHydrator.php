<?php

namespace Luni\Component\MagentoDriver\Hydrator;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Entity\ProductInterface;
use Luni\Component\MagentoDriver\Exception\InvalidArgumentException;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Repository\ProductAttributeRepositoryInterface;
use Luni\Component\MagentoDriver\Repository\ProductAttributeValueRepositoryInterface;

class ProductAttributeValueHydrator
    implements ProductAttributeValueHydratorInterface
{
    /**
     * @var ProductAttributeValueRepositoryInterface
     */
    private $attributeValueRepository;

    /**
     * @var ProductAttributeRepositoryInterface
     */
    private $attributeRepository;

    /**
     * @param ProductAttributeValueRepositoryInterface $attributeValueRepository
     * @param ProductAttributeRepositoryInterface $attributeRepository
     */
    public function __construct(
        ProductAttributeValueRepositoryInterface $attributeValueRepository,
        ProductAttributeRepositoryInterface $attributeRepository
    ) {
        $this->attributeValueRepository = $attributeValueRepository;
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * @param ProductInterface $product
     * @param int $storeId
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
     * @param ProductInterface $product
     * @param AttributeInterface[] $attributeList
     * @param int $storeId
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
     * @return Collection|ProductInterface[]
     */
    private function transformListToCollection(array $productList)
    {
        $productCollection = new ArrayCollection();
        /** @var ProductInterface $product */
        foreach ($productList as $product) {
            if (!$product instanceof ProductInterface) {
                throw new InvalidArgumentException(sprintf('Passed array elements should be %s instances, %s found.',
                    ProductInterface::class, get_class($product)));
            }

            $productCollection->set($product->getId(), $product);
        }

        return $productCollection;
    }

    /**
     * @param ProductInterface[] $productList
     * @param int $storeId
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
     * @param ProductInterface[] $productList
     * @param AttributeInterface[] $attributeList
     * @param int $storeId
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