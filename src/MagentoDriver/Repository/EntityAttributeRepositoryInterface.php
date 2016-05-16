<?php

namespace Luni\Component\MagentoDriver\Repository;

use Luni\Component\MagentoDriver\Model\EntityAttributeInterface;

interface EntityAttributeRepositoryInterface
{

    /**
     * @param int $id
     *
     * @return EntityAttributeInterface
     */
    public function findOneById($id);
    
    /**
     * return all statements
     */
    public function findAll();
    
    /**
     * 
     * @param int $attributeId
     * @param int $attributeGroupId
      */
    public function findOneByAttributeIdAndGroupId($attributeId, $attributeGroupId);
    
    /**
     * 
     * @param type $attributeId
     * @param type $attributeSetId
      */
    public function findOneByAttributeIdAndSetId($attributeId, $attributeSetId);
}
