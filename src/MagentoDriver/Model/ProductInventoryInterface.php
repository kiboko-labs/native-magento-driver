<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface ProductInventoryInterface
{
    /**
     * @return bool
     */
    public function isAvailable();

    /**
     * @return bool
     */
    public function isStockManaged();

    /**
     * @return bool
     */
    public function canPreOrder();

    /**
     * @return int
     */
    public function getAvailableQty();
}