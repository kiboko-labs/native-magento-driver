<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

class EntityType implements EntityTypeInterface
{
    use MappableTrait;
    use IdentifiableTrait;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $entityModelClass;

    /**
     * @var string
     */
    private $attributeModelClass;

    /**
     * @var string
     */
    private $entityTable;

    /**
     * @var string
     */
    private $valueTablePrefix;

    /**
     * @var string
     */
    private $entityIdField;

    /**
     * @var bool
     */
    private $dataSharing;

    /**
     * @var string
     */
    private $dataSharingKey;

    /**
     * @var string
     */
    private $defaultAttributeSetId;

    /**
     * @var string
     */
    private $incrementModel;

    /**
     * @var string
     */
    private $incrementPerStore;

    /**
     * @var string
     */
    private $incrementPadLength;

    /**
     * @var string
     */
    private $incrementPadChar;

    /**
     * @var string
     */
    private $additionalAttributeTable;

    /**
     * @var string
     */
    private $attributeCollectionClass;

    /**
     * EntityType constructor.
     *
     * @param $code
     * @param $entityModelClass
     * @param $attributeModelClass
     * @param $entityTable
     * @param $valueTablePrefix
     * @param $entityIdField
     * @param $dataSharing
     * @param $dataSharingKey
     * @param $defaultAttributeSetId
     * @param $incrementModel
     * @param $incrementPerStore
     * @param $incrementPadLength
     * @param $incrementPadChar
     * @param $additionalAttributeTable
     * @param $attributeCollectionClass
     */
    public function __construct(
        $code,
        $entityModelClass,
        $attributeModelClass,
        $entityTable,
        $valueTablePrefix,
        $entityIdField,
        $dataSharing,
        $dataSharingKey,
        $defaultAttributeSetId,
        $incrementModel,
        $incrementPerStore,
        $incrementPadLength,
        $incrementPadChar,
        $additionalAttributeTable,
        $attributeCollectionClass
    ) {
        $this->code = $code;
        $this->entityModelClass = $entityModelClass;
        $this->attributeModelClass = $attributeModelClass;
        $this->entityTable = $entityTable;
        $this->valueTablePrefix = $valueTablePrefix;
        $this->entityIdField = $entityIdField;
        $this->dataSharing = $dataSharing;
        $this->dataSharingKey = $dataSharingKey;
        $this->defaultAttributeSetId = $defaultAttributeSetId;
        $this->incrementModel = $incrementModel;
        $this->incrementPerStore = $incrementPerStore;
        $this->incrementPadLength = $incrementPadLength;
        $this->incrementPadChar = $incrementPadChar;
        $this->additionalAttributeTable = $additionalAttributeTable;
        $this->attributeCollectionClass = $attributeCollectionClass;
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
        return $this->entityModelClass;
    }

    /**
     * @return string
     */
    public function getAttributeModelClass()
    {
        return $this->attributeModelClass;
    }

    /**
     * @return string
     */
    public function getEntityTable()
    {
        return $this->entityTable;
    }

    /**
     * @return string
     */
    public function getValueTablePrefix()
    {
        return $this->valueTablePrefix;
    }

    /**
     * @return string
     */
    public function getEntityIdField()
    {
        return $this->entityIdField;
    }

    /**
     * @return bool
     */
    public function isDataSharing()
    {
        return $this->dataSharing;
    }

    /**
     * @return FamilyInterface
     */
    public function getDataSharingKey()
    {
        return $this->dataSharingKey;
    }

    /**
     * @return FamilyInterface
     */
    public function getDefaultFamily()
    {
        return $this->defaultFamily;
    }

    /**
     * @return string
     */
    public function getIncrementModel()
    {
        return $this->incrementModel;
    }

    /**
     * @return bool
     */
    public function isIncrementedByStore()
    {
        return $this->incrementPerStore;
    }

    /**
     * @return string
     */
    public function getIncrementPadChar()
    {
        return $this->incrementPadChar;
    }

    /**
     * @return string
     */
    public function getIncrementPadLength()
    {
        return $this->incrementPadChar;
    }

    /**
     * @return string
     */
    public function getExtendedAttributeTable()
    {
        return $this->extendedAttributeTable;
    }

    /**
     * @return string
     */
    public function getAttributeCollectionClass()
    {
        return $this->attributeCollectionClass;
    }

    /**
     * @param int    $entityTypeId
     * @param string $code
     * @param string $entityModelClass
     * @param string $attributeModelClass
     * @param string $entityTable
     * @param string $valueTablePrefix
     * @param string $entityIdField
     * @param bool   $dataSharing
     * @param string $dataSharingKey
     * @param int    $defaultAttributeSetId
     * @param string $incrementModel
     * @param bool   $incrementPerStore
     * @param int    $incrementPadLength
     * @param string $incrementPadChar
     * @param string $additionalAttributeTable
     * @param string $attributeCollectionClass
     *
     * @return EntityTypeInterface
     */
    public static function buildNewWith(
        $entityTypeId,
        $code,
        $entityModelClass,
        $attributeModelClass,
        $entityTable,
        $valueTablePrefix,
        $entityIdField,
        $dataSharing,
        $dataSharingKey,
        $defaultAttributeSetId,
        $incrementModel,
        $incrementPerStore,
        $incrementPadLength,
        $incrementPadChar,
        $additionalAttributeTable,
        $attributeCollectionClass
    ) {
        $object = new self(
            $code,
            $entityModelClass,
            $attributeModelClass,
            $entityTable,
            $valueTablePrefix,
            $entityIdField,
            $dataSharing,
            $dataSharingKey,
            $defaultAttributeSetId,
            $incrementModel,
            $incrementPerStore,
            $incrementPadLength,
            $incrementPadChar,
            $additionalAttributeTable,
            $attributeCollectionClass
        );

        $object->persistedToId($entityTypeId);

        return $object;
    }
}
