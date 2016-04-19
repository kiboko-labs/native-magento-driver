<?php

namespace Luni\Component\MagentoDriver\Model;

class EntityStore implements EntityStoreInterface
{
    /**
     * @param int    $id
     * @param string $typeId
     * @param string $storeId
     * @param string $incrementPrefix
     * @param string $incrementLastId
     */
    public function __construct($id, $typeId, $storeId, $incrementPrefix, $incrementLastId)
    {
        $this->id = $id;
        $this->typeId = $typeId;
        $this->storeId = $storeId;
        $this->incrementPrefix = $incrementPrefix;
        $this->incrementLastId = $incrementLastId;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function persistToId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * @return string
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * @return string
     */
    public function getIncrementPrefix()
    {
        return $this->incrementPrefix;
    }

    /**
     * @return string
     */
    public function getIncrementLastId()
    {
        return $this->incrementLastId;
    }

    /**
     * @param int    $id
     * @param string $typeId
     * @param string $storeId
     * @param string $incrementPrefix
     * @param string $incrementLastId
     *
     * @return EntityStoreInterface
     */
    public static function buildNewWith($id, $typeId, $storeId, $incrementPrefix, $incrementLastId)
    {
        $object = new self($id, $typeId, $storeId, $incrementPrefix, $incrementLastId);

        return $object;
    }
}
