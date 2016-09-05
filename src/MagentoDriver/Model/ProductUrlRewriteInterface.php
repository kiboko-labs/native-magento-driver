<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface ProductUrlRewriteInterface extends MappableInterface
{
    /**
     * @return string
     */
    public function getUrl();
}
