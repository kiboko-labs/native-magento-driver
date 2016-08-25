<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface StoreInterface
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
