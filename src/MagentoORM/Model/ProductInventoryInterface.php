<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

interface ProductInventoryInterface extends MappableInterface
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
