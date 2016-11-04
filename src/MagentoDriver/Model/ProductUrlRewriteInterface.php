<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model;

interface ProductUrlRewriteInterface extends MappableInterface
{
    /**
     * @return string
     */
    public function getUrl();
}
