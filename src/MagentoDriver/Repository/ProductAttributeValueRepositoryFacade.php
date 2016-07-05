<?php

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Broker\ProductAttributeValueRepositoryBrokerInterface;
use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeValueInterface;

class ProductAttributeValueRepositoryFacade implements ProductAttributeValueRepositoryInterface
{
    /**
     * @var ProductAttributeValueRepositoryBrokerInterface
     */
    private $broker;

    /**
     * @param ProductAttributeValueRepositoryBrokerInterface $broker
     */
    public function __construct(
        ProductAttributeValueRepositoryBrokerInterface $broker
    ) {
        $this->broker = $broker;
    }

    /**
     * @param ProductInterface $product
     *
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllByProduct(ProductInterface $product)
    {
        foreach ($this->broker->walkRepositoryList() as $repository) {
            foreach ($repository->findAllByProduct($product) as $attributeValue) {
                yield $attributeValue;
            }
        }
    }

    /**
     * @param ProductInterface $product
     *
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllVariantAxisByProductFromDefault(ProductInterface $product)
    {
        foreach ($this->broker->walkRepositoryList() as $repository) {
            foreach ($repository->findAllVariantAxisByProductFromDefault($product) as $attributeValue) {
                yield $attributeValue;
            }
        }
    }

    /**
     * @param ProductInterface $product
     * @param int              $storeId
     *
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllVariantAxisByProductFromStoreId(ProductInterface $product, $storeId)
    {
        foreach ($this->broker->walkRepositoryList() as $repository) {
            foreach ($repository->findAllVariantAxisByProductFromStoreId($product, $storeId) as $attributeValue) {
                yield $attributeValue;
            }
        }
    }

    /**
     * @param ProductInterface $product
     * @param array $attributeList
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllByProductAndAttributeListFromDefault(
        ProductInterface $product,
        array $attributeList
    ) {
        foreach ($this->broker->walkRepositoryList() as $repository) {
            foreach ($repository->findAllByProductAndAttributeListFromDefault($product, $attributeList) as $attributeValue) {
                yield $attributeValue;
            }
        }
    }

    /**
     * @param ProductInterface $product
     * @param array $attributeList
     * @param int $storeId
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllByProductAndAttributeListFromStoreId(
        ProductInterface $product,
        array $attributeList,
        $storeId
    ) {
        foreach ($this->broker->walkRepositoryList() as $repository) {
            foreach ($repository->findAllByProductAndAttributeListFromStoreId($product, $attributeList, $storeId) as $attributeValue) {
                yield $attributeValue;
            }
        }
    }

    /**
     * @param ProductInterface   $product
     * @param AttributeInterface $attribute
     *
     * @return AttributeValueInterface|null
     */
    public function findOneByProductAndAttributeFromDefault(
        ProductInterface $product,
        AttributeInterface $attribute
    ) {
        foreach ($this->broker->walkRepositoryList() as $matcher => $repository) {
            if (!$matcher($attribute)) {
                continue;
            }

            return $repository->findOneByProductAndAttributeFromDefault($product, $attribute);
        }

        return;
    }

    /**
     * @param ProductInterface   $product
     * @param AttributeInterface $attribute
     * @param int                $storeId
     *
     * @return AttributeValueInterface|null
     */
    public function findOneByProductAndAttributeFromStoreId(
        ProductInterface $product,
        AttributeInterface $attribute,
        $storeId
    ) {
        foreach ($this->broker->walkRepositoryList() as $matcher => $repository) {
            if (!$matcher($attribute)) {
                continue;
            }

            return $repository->findOneByProductAndAttributeFromStoreId($product, $attribute, $storeId);
        }

        return;
    }

    /**
     * @param array $productList
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllByProductListFromDefault(
        array $productList
    ) {
        foreach ($this->broker->walkRepositoryList() as $repository) {
            foreach ($repository->findAllByProductListFromDefault($productList) as $attributeValue) {
                yield $attributeValue;
            }
        }
    }

    /**
     * @param array $productList
     * @param int $storeId
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllByProductListFromStoreId(
        array $productList,
        $storeId
    ) {
        foreach ($this->broker->walkRepositoryList() as $repository) {
            foreach ($repository->findAllByProductListFromStoreId($productList, $storeId) as $attributeValue) {
                yield $attributeValue;
            }
        }
    }

    /**
     * @param array $productList
     * @param array $attributeList
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllByProductListAndAttributeListFromDefault(
        array $productList,
        array $attributeList
    ) {
        foreach ($this->broker->walkRepositoryList() as $repository) {
            foreach ($repository->findAllByProductListAndAttributeListFromDefault($productList, $attributeList) as $attributeValue) {
                yield $attributeValue;
            }
        }
    }

    /**
     * @param array $productList
     * @param array $attributeList
     * @param int $storeId
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllByProductListAndAttributeListFromStoreId(
        array $productList,
        array $attributeList,
        $storeId
    ) {
        foreach ($this->broker->walkRepositoryList() as $repository) {
            foreach ($repository->findAllByProductListAndAttributeListFromStoreId($productList, $attributeList, $storeId) as $attributeValue) {
                yield $attributeValue;
            }
        }
    }

    /**
     * @param ProductInterface $product
     *
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllByProductFromDefault(ProductInterface $product)
    {
        foreach ($this->broker->walkRepositoryList() as $repository) {
            foreach ($repository->findAllByProductFromDefault($product) as $attributeValue) {
                yield $attributeValue;
            }
        }
    }

    /**
     * @param ProductInterface $product
     * @param int              $storeId
     *
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllByProductFromStoreId(ProductInterface $product, $storeId)
    {
        foreach ($this->broker->walkRepositoryList() as $repository) {
            foreach ($repository->findAllByProductFromStoreId($product, $storeId) as $attributeValue) {
                yield $attributeValue;
            }
        }
    }
}
