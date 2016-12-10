<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Transformer\Attribute;

use Kiboko\Component\AkeneoToMagentoMapper\Transformer\AdminLocaleCodeAwareInterface;
use Kiboko\Component\MagentoORM\Repository\StoreRepositoryInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Mapper\AttributeGroupMapperInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Mapper\FamilyMapperInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Transformer\AttributeGroupTransformerInterface;
use Pim\Component\Catalog\Repository\FamilyRepositoryInterface;
use Pim\Component\Catalog\Model\AttributeGroupInterface as PimAttributeGroupInterface;

abstract class AbstractAttributeGroupTransformer implements AttributeGroupTransformerInterface, AdminLocaleCodeAwareInterface
{
    /**
     * @var AttributeGroupMapperInterface
     */
    protected $attributeGroupMapper;

    /**
     * @var FamilyMapperInterface
     */
    protected $familyMapper;

    /**
     * @var FamilyRepositoryInterface
     */
    protected $familyRepository;

    /**
     * @var StoreRepositoryInterface
     */
    protected $storeRepository;

    /**
     * @var string
     */
    protected $adminLocaleCode;

    /**
     * @var string[]
     */
    protected $storeLocaleCodes;

    /**
     * AttributeGroupOptionTransformer constructor.
     *
     * @param AttributeGroupMapperInterface $attributeGroupMapper
     * @param FamilyMapperInterface         $familyMapper
     * @param FamilyRepositoryInterface     $familyRepository
     * @param StoreRepositoryInterface      $storeRepository
     * @param string                        $adminLocaleCode
     * @param array                         $storeLocaleCodes
     */
    public function __construct(
        AttributeGroupMapperInterface $attributeGroupMapper,
        FamilyMapperInterface $familyMapper,
        FamilyRepositoryInterface $familyRepository,
        StoreRepositoryInterface $storeRepository,
        $adminLocaleCode = null,
        array $storeLocaleCodes = []
    ) {
        $this->attributeGroupMapper = $attributeGroupMapper;
        $this->familyMapper = $familyMapper;
        $this->familyRepository = $familyRepository;
        $this->storeRepository = $storeRepository;
        $this->adminLocaleCode = $adminLocaleCode;
        $this->storeLocaleCodes = $storeLocaleCodes;
    }

    /**
     * @param string $adminLocaleCode
     *
     * @return $this
     */
    public function setAdminLocaleCode($adminLocaleCode)
    {
        $this->adminLocaleCode = $adminLocaleCode;

        return $this;
    }

    /**
     * @param PimAttributeGroupInterface $family
     *
     * @return bool
     */
    public function supportsTransformation(PimAttributeGroupInterface $family)
    {
        return true;
    }
}
