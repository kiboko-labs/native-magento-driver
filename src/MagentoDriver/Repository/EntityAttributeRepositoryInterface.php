<?php

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Model\EntityAttributeInterface;

interface EntityAttributeRepositoryInterface
{
    /**
     * @param int $identifier
     *
     * @return EntityAttributeInterface
     */
    public function findOneById($identifier);

    /**
     * return \Traversable|EntityAttributeInterface[]
     */
    public function findAll();

    /**
     * @param int $attributeId
     * @param int $attributeGroupId
     */
    public function findOneByAttributeIdAndGroupId($attributeId, $attributeGroupId);

    /**
     * @param int $attributeId
     * @param int $attributeSetId
     */
    public function findOneByAttributeIdAndSetId($attributeId, $attributeSetId);
}
