<?php

namespace Luni\Component\MagentoDriver\Model;

interface AttributeLabelInterface
{

    /**
     * @return int
     */
    public function getId();

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
