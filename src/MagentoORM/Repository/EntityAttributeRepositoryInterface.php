<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository;

use Kiboko\Component\MagentoORM\Model\EntityAttributeInterface;

interface EntityAttributeRepositoryInterface
{
    /**
     * @param int $identifier
     *
     * @return EntityAttributeInterface
     */
    public function findOneById($identifier);

    /**
     * return \Traversable|EntityAttributeInterface[].
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
