<?php

namespace Kiboko\Component\MagentoDriver\Model;

class EntityType implements EntityTypeInterface
{
    use MappableTrait;

    /**
     * @var string
     */
    private $code;

    /**
     * @todo finish to implement
     */

    /**
     * EntityType constructor.
     * @param $code
     * @param $modelClass
     * @param $attributeModel
     * @param $entityTable
     * @param $valueTablePrefix
     * @param $entityIdField
     * @param $isDataSharing
     * @param $dataSharingKey
     * @param $defaultAttributeSetId
     * @param $incrementModel
     * @param $incrementPerStore
     * @param $incrementPadLength
     * @param $incrementPadChar
     * @param $additionalAttributeTable
     * @param $entityAttributeCollection
     */
    public function __construct(
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
        $this->code = $code;
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
