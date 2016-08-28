<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface AttributeLabelInterface extends MappableInterface, IdentifiableInterface
{
    /**
     * @return int
     */
    public function getAttributeId();

    /**
     * @return int
     */
    public function getStoreId();

    /**
     * @return string
     */
    public function getValue();
}
