<?php

namespace Kiboko\Component\MagentoDriver\Repository\CachedRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\FamilyInterface;
use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Repository\ProductAttributeRepositoryInterface;

/**
 * Class ProductAttributeRepository.
 */
class CachedProductAttributeRepository implements ProductAttributeRepositoryInterface
{
    /**
     * @var ProductAttributeRepositoryInterface
     */
    protected $decorated;

    /**
     * @var Collection
     */
    protected $attributeCacheByCode;

    /**
     * @var Collection
     */
    protected $attributeCacheById;

    /**
     * ProductAttributeRepository constructor.
     *
     * @param ProductAttributeRepositoryInterface $repository
     */
    public function __construct(
        ProductAttributeRepositoryInterface $repository
    ) {
        $this->decorated = $repository;

        $this->attributeCacheByCode = new ArrayCollection();
        $this->attributeCacheById = new ArrayCollection();
    }

    /**
     * @param string $code
     * @param string $entityTypeId
     *
     * @return AttributeInterface
     */
    public function findOneByCode($code, $entityTypeId)
    {
        if ($this->attributeCacheByCode->containsKey($code)) {
            return $this->attributeCacheByCode->get($code);
        }

        $attribute = $this->decorated->findOneByCode($code, $entityTypeId);

        $this->attributeCacheByCode->set($attribute->getCode(), $attribute);
        $this->attributeCacheById->set($attribute->getId(), $attribute);

        return $attribute;
    }

    /**
     * @param int $identifier
     *
     * @return AttributeInterface
     */
    public function findOneById($identifier)
    {
        if ($this->attributeCacheByCode->containsKey($identifier)) {
            return $this->attributeCacheById->get($identifier);
        }

        $attribute = $this->decorated->findOneById($identifier);

        $this->attributeCacheByCode->set($attribute->getCode(), $attribute);
        $this->attributeCacheById->set($attribute->getId(), $attribute);

        return $attribute;
    }

    /**
     * @param string         $entityTypeCode
     * @param array|string[] $codeList
     *
     * @return Collection|AttributeInterface[]
     */
    public function findAllByCode($entityTypeCode, array $codeList)
    {
        $attributeList = new ArrayCollection();
        $codeSearch = [];
        foreach ($codeList as $code) {
            if (!$this->attributeCacheByCode->containsKey($code)) {
                $codeSearch[] = $code;
                continue;
            }

            $attributeList->set($code, $this->attributeCacheByCode->get($code));
        }

        if (count($codeSearch) <= 0) {
            return $attributeList;
        }

        $searchedAttributeList = $this->decorated->findAllByCode($entityTypeCode, $codeSearch);
        foreach ($searchedAttributeList as $attribute) {
            $code = $attribute->getCode();
            $attributeList->set($code, $attribute);

            $this->attributeCacheById->set($attribute->getId(), $attribute);
            $this->attributeCacheByCode->set($code, $attribute);
        }

        return $attributeList;
    }

    /**
     * @param array|int[] $idList
     *
     * @return Collection|AttributeInterface[]
     */
    public function findAllById(array $idList)
    {
        $attributeList = new ArrayCollection();
        $idSearch = [];
        foreach ($idList as $identifier) {
            if (!$this->attributeCacheByCode->containsKey($identifier)) {
                $idSearch[] = $identifier;
                continue;
            }

            $attributeList->set($identifier, $this->attributeCacheByCode->get($identifier));
        }

        if (count($idSearch) <= 0) {
            return $attributeList;
        }

        $searchedAttributeList = $this->decorated->findAllById($idSearch);
        foreach ($searchedAttributeList as $attribute) {
            $identifier = $attribute->getId();
            $attributeList->set($identifier, $attribute);

            $this->attributeCacheById->set($identifier, $attribute);
            $this->attributeCacheByCode->set($attribute->getCode(), $attribute);
        }

        return $attributeList;
    }

    /**
     * @return Collection|AttributeInterface[]
     */
    public function findAll()
    {
        return $this->decorated->findAll();
    }

    /**
     * @param ProductInterface $product
     *
     * @return Collection|AttributeInterface[]
     */
    public function findAllByEntity(ProductInterface $product)
    {
        return $this->decorated->findAllByEntity($product);
    }

    /**
     * @param ProductInterface $product
     *
     * @return Collection|AttributeInterface[]
     */
    public function findAllVariantAxisByEntity(ProductInterface $product)
    {
        return $this->decorated->findAllVariantAxisByEntity($product);
    }

    /**
     * @param FamilyInterface $family
     *
     * @return Collection|AttributeInterface[]
     */
    public function findAllByFamily(FamilyInterface $family)
    {
        return $this->decorated->findAllByFamily($family);
    }

    /**
     * @param FamilyInterface $family
     *
     * @return Collection|AttributeInterface[]
     */
    public function findAllMandatoryByFamily(FamilyInterface $family)
    {
        return $this->decorated->findAllMandatoryByFamily($family);
    }
}
