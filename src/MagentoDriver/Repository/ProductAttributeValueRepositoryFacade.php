<?php

namespace Luni\Component\MagentoDriver\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Broker\ProductAttributeValueRepositoryBrokerInterface;
use Luni\Component\MagentoDriver\Entity\ProductInterface;
use Luni\Component\MagentoDriver\Exception\InvalidAttributeValueRepositoryTypeException;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;

class ProductAttributeValueRepositoryFacade
    implements ProductAttributeValueRepositoryInterface
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
     * @return Collection|AttributeValueInterface[]
     */
    public function findAllByProduct(ProductInterface $product)
    {
        $valuesList = [];
        foreach ($this->broker->walkRepositoryList() as $repository) {
            $valuesList = array_merge(
                $valuesList,
                $repository->findAllByProduct($product)->toArray()
            );
        }

        return new ArrayCollection($valuesList);
    }

    /**
     * @param ProductInterface $product
     * @return Collection|AttributeValueInterface[]
     */
    public function findAllVariantAxisByProduct(ProductInterface $product)
    {
        $valuesList = [];
        foreach ($this->broker->walkRepositoryList() as $repository) {
            $valuesList = array_merge(
                $valuesList,
                $repository->findAllVariantAxisByProduct($product)->toArray()
            );
        }

        return new ArrayCollection($valuesList);
    }

    /**
     * @param ProductInterface $product
     * @return Collection|AttributeValueInterface[]
     */
    public function findAllMandatoryByProduct(ProductInterface $product)
    {
        $valuesList = [];
        foreach ($this->broker->walkRepositoryList() as $repository) {
            $valuesList = array_merge(
                $valuesList,
                $repository->findAllMandatoryByProduct($product)->toArray()
            );
        }

        return new ArrayCollection($valuesList);
    }

    /**
     * @param ProductInterface $product
     * @param AttributeInterface $attribute
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

        return null;
    }

    /**
     * @param ProductInterface $product
     * @param AttributeInterface $attribute
     * @param int $storeId
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

        return null;
    }

    /**
     * @param ProductInterface $product
     * @return Collection|AttributeValueInterface[]
     */
    public function findAllByProductFromDefault(ProductInterface $product)
    {
        $valuesList = [];
        foreach ($this->broker->walkRepositoryList() as $repository) {
            $valuesList = array_merge(
                $valuesList,
                $repository->findAllByProductFromDefault($product)->toArray()
            );
        }

        return new ArrayCollection($valuesList);
    }

    /**
     * @param ProductInterface $product
     * @param int $storeId
     * @return Collection|AttributeValueInterface[]
     */
    public function findAllByProductFromStoreId(ProductInterface $product, $storeId)
    {
        $valuesList = [];
        foreach ($this->broker->walkRepositoryList() as $repository) {
            $valuesList = array_merge(
                $valuesList,
                $repository->findAllByProductFromStoreId($product, $storeId)->toArray()
            );
        }

        return new ArrayCollection($valuesList);
    }
}