<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface EntityStoreInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     */
    public function persistToId($id);

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
