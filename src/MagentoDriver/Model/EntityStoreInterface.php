<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface EntityStoreInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $identifier
     */
    public function persistToId($identifier);

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
