<?php

namespace Luni\Component\MagentoDriver\Model;

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
