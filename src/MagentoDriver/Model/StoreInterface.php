<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface StoreInterface extends MappableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getCode();
}
