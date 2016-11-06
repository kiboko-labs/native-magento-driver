<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

class ProductInventory implements ProductInventoryInterface
{
    use MappableTrait;

    /**
     * @return bool
     */
    public function isAvailable()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isStockManaged()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function canPreOrder()
    {
        return false;
    }

    /**
     * @return int
     */
    public function getAvailableQty()
    {
        return 10;
    }
}
