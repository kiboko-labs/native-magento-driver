<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface EntityTypeInterface
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
    public function getCode();

    /**
     * @return string
     */
    public function getEntityModelClass();

    /**
     * @return string
     */
    public function getAttributeModelClass();

    /**
     * @return string
     */
    public function getEntityTable();

    /**
     * @return string
     */
    public function getValueTablePrefix();

    /**
     * @return string
     */
    public function getEntityIdField();

    /**
     * @return bool
     */
    public function isDataSharing();

    /**
     * @return FamilyInterface
     */
    public function getDataSharingKey();

    /**
     * @return FamilyInterface
     */
    public function getDefaultFamily();

    /**
     * @return string
     */
    public function getIncrementModel();

    /**
     * @return bool
     */
    public function isIncrementedByStore();

    /**
     * @return int
     */
    public function getIncrementPadChar();

    /**
     * @return string
     */
    public function getIncrementPadLength();

    /**
     * @return string
     */
    public function getExtendedAttributeTable();

    /**
     * @return string
     */
    public function getAttributeCollectionClass();
}
