<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Repository\CachedRepository;

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

        $this->attributeCacheByCode = [];
        $this->attributeCacheById = [];
    }

    /**
     * @param string $code
     * @param string $entityTypeId
     *
     * @return AttributeInterface
     */
    public function findOneByCode($code, $entityTypeId)
    {
        if (isset($this->attributeCacheByCode[$code])) {
            return $this->attributeCacheByCode[$code];
        }

        $attribute = $this->decorated->findOneByCode($code, $entityTypeId);

        $this->attributeCacheByCode[$attribute->getCode()] = $attribute;
        $this->attributeCacheById[$attribute->getId()] = $attribute;

        return $attribute;
    }

    /**
     * @param int $identifier
     *
     * @return AttributeInterface
     */
    public function findOneById($identifier)
    {
        if (isset($this->attributeCacheByCode[$identifier])) {
            return $this->attributeCacheByCode[$identifier];
        }

        $attribute = $this->decorated->findOneById($identifier);

        $this->attributeCacheByCode[$attribute->getCode()] = $attribute;
        $this->attributeCacheById[$attribute->getId()] = $attribute;

        return $attribute;
    }

    /**
     * @param string         $entityTypeCode
     * @param array|string[] $codeList
     *
     * @return \Traversable|AttributeInterface[]
     */
    public function findAllByCode($entityTypeCode, array $codeList)
    {
        $codeSearch = [];
        foreach ($codeList as $code) {
            if (!isset($this->attributeCacheByCode[$code])) {
                $codeSearch[] = $code;
                continue;
            }

            yield $code => $this->attributeCacheByCode[$code];
        }

        if (count($codeSearch) <= 0) {
            return;
        }

        foreach ($this->decorated->findAllByCode($entityTypeCode, $codeSearch) as $attribute) {
            $code = $attribute->getCode();

            $this->attributeCacheById[$attribute->getId()] = $attribute;
            $this->attributeCacheByCode[$code] = $attribute;

            yield $code => $attribute;
        }
    }

    /**
     * @param array|int[] $idList
     *
     * @return \Traversable|AttributeInterface[]
     */
    public function findAllById(array $idList)
    {
        $identifierSearch = [];
        foreach ($idList as $identifier) {
            if (!isset($this->attributeCacheByCode[$identifier])) {
                $identifierSearch[] = $identifier;
                continue;
            }

            yield $identifier => $this->attributeCacheByCode[$identifier];
        }

        if (count($identifierSearch) <= 0) {
            return;
        }

        foreach ($this->decorated->findAllById($identifierSearch) as $attribute) {
            $identifier = $attribute->getId();

            $this->attributeCacheById[$identifier] = $attribute;
            $this->attributeCacheByCode[$attribute->getCode()] = $attribute;

            yield $identifier => $attribute;
        }
    }

    /**
     * @return \Traversable|AttributeInterface[]
     */
    public function findAll()
    {
        return $this->decorated->findAll();
    }

    /**
     * @param ProductInterface $product
     *
     * @return \Traversable|AttributeInterface[]
     */
    public function findAllByEntity(ProductInterface $product)
    {
        return $this->decorated->findAllByEntity($product);
    }

    /**
     * @param ProductInterface $product
     *
     * @return \Traversable|AttributeInterface[]
     */
    public function findAllVariantAxisByEntity(ProductInterface $product)
    {
        return $this->decorated->findAllVariantAxisByEntity($product);
    }

    /**
     * @param FamilyInterface $family
     *
     * @return \Traversable|AttributeInterface[]
     */
    public function findAllByFamily(FamilyInterface $family)
    {
        return $this->decorated->findAllByFamily($family);
    }

    /**
     * @param FamilyInterface $family
     *
     * @return \Traversable|AttributeInterface[]
     */
    public function findAllMandatoryByFamily(FamilyInterface $family)
    {
        return $this->decorated->findAllMandatoryByFamily($family);
    }
}
