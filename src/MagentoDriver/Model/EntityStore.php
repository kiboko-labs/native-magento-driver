<?php

namespace Kiboko\Component\MagentoDriver\Model;

class EntityStore implements EntityStoreInterface
{
    use MappableTrait;

    /**
     * @var
     */
    private $identifier;

    /**
     * @var int
     */
    private $typeId;

    /**
     * @var int
     */
    private $storeId;

    /**
     * @var string
     */
    private $incrementPrefix;

    /**
     * @var string
     */
    private $incrementLastId;

    /**
     * @param int    $typeId
     * @param int    $storeId
     * @param string $incrementPrefix
     * @param string $incrementLastId
     */
    public function __construct($typeId, $storeId, $incrementPrefix, $incrementLastId)
    {
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
        return $this->identifier;
    }

    /**
     * @param int $identifier
     */
    public function persistToId($identifier)
    {
        $this->identifier = $identifier;
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
     * @param int    $identifier
     * @param string $typeId
     * @param string $storeId
     * @param string $incrementPrefix
     * @param string $incrementLastId
     *
     * @return EntityStoreInterface
     */
    public static function buildNewWith($identifier, $typeId, $storeId, $incrementPrefix, $incrementLastId)
    {
        $object = new self($typeId, $storeId, $incrementPrefix, $incrementLastId);

        $object->identifier = $identifier;

        return $object;
    }
}
