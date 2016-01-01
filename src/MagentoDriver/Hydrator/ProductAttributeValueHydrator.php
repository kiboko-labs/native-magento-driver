<?php

namespace Luni\Component\MagentoDriver\Hydrator;

use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Entity\ProductInterface;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
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
}