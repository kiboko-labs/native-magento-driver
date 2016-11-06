<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

interface ScopableAttributeValueInterface extends AttributeValueInterface
{
    /**
     * @param $storeId
     *
     * @return AttributeValueInterface
     */
    public function copyToStoreId($storeId);

    /**
     * @return int|null
     */
    public function getStoreId();
}
