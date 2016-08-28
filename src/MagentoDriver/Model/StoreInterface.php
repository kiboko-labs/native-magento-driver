<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface StoreInterface extends MappableInterface, IdentifiableInterface
{
    /**
     * @return string
     */
    public function getCode();
    
    /**
     * @return string
     */
    public function getName();
}
