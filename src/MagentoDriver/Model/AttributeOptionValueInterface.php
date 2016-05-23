<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface AttributeOptionValueInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return int
     */
    public function getOptionId();

    /**
     * @return int
     */
    public function getStoreId();

    /**
     * @return string
     */
    public function getValue();
}
