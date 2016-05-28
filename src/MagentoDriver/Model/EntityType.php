<?php

namespace Kiboko\Component\MagentoDriver\Model;

class EntityType implements EntityTypeInterface
{
    /**
     * @todo finish to implement
     */

    /**
     * @param int    $id
     * @param string $code
     */
    public function __construct($id, $code)
    {
        $this->id = $id;
        $this->code = $code;
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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getEntityModelClass()
    {
    }

    /**
     * @return string
     */
    public function getAttributeModelClass()
    {
    }

    /**
     * @return string
     */
    public function getEntityTable()
    {
    }

    /**
     * @return string
     */
    public function getValueTablePrefix()
    {
    }

    /**
     * @return string
     */
    public function getEntityIdField()
    {
    }

    /**
     * @return bool
     */
    public function isDataSharing()
    {
    }

    /**
     * @return FamilyInterface
     */
    public function getDataSharingKey()
    {
    }

    /**
     * @return FamilyInterface
     */
    public function getDefaultFamily()
    {
    }

    /**
     * @return string
     */
    public function getIncrementModel()
    {
    }

    /**
     * @return bool
     */
    public function isIncrementedByStore()
    {
    }

    /**
     * @return int
     */
    public function getIncrementPadChar()
    {
    }

    /**
     * @return string
     */
    public function getIncrementPadLength()
    {
    }

    /**
     * @return string
     */
    public function getExtendedAttributeTable()
    {
    }

    /**
     * @return string
     */
    public function getAttributeCollectionClass()
    {
    }

    /**
     * @param int    $entityTypeId
     * @param string $code
     * @param string $modelClass
     * @param string $attributeModel
     * @param string $entityTable
     * @param string $valueTablePrefix
     * @param string $entityIdField
     * @param type   $isDataSharing
     * @param string $dataSharingKey
     * @param type   $defaultAttributeSetId
     * @param string $incrementModel
     * @param type   $incrementPerStore
     * @param type   $incrementPadLength
     * @param string $incrementPadChar
     * @param string $additionalAttributeTable
     * @param string $entityAttributeCollection
     *
     * @return EntityTypeInterface
     */
    public static function buildNewWith(
        $entityTypeId,
        $code,
        $modelClass,
        $attributeModel,
        $entityTable,
        $valueTablePrefix,
        $entityIdField,
        $isDataSharing,
        $dataSharingKey,
        $defaultAttributeSetId,
        $incrementModel,
        $incrementPerStore,
        $incrementPadLength,
        $incrementPadChar,
        $additionalAttributeTable,
        $entityAttributeCollection
    ) {
        $object = new self(
            $entityTypeId,
            $code,
            $modelClass,
            $attributeModel,
            $entityTable,
            $valueTablePrefix,
            $entityIdField,
            $isDataSharing,
            $dataSharingKey,
            $defaultAttributeSetId,
            $incrementModel,
            $incrementPerStore,
            $incrementPadLength,
            $incrementPadChar,
            $additionalAttributeTable,
            $entityAttributeCollection
        );

        return $object;
    }
}
