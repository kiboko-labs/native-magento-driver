<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface EntityStoreInterface extends MappableInterface, IdentifiableInterface
{
    /**
     * @return string
     */
    public function getTypeId();

    /**
     * @return string
     */
    public function getStoreId();

    /**
     * @return string
     */
    public function getIncrementPrefix();

    /**
     * @return string
     */
    public function getIncrementLastId();
}
