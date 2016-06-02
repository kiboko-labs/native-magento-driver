<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface AttributeInterface
{
    /**
     * @return int
     * @field attribute_id
     */
    public function getId();

    /**
     * @param int $identifier
     */
    public function persistedToId($identifier);

    /**
     * @return int
     * @field entity_type_id
     */
    public function getEntityTypeId();

    /**
     * @return string
     * @field attribute_code
     */
    public function getCode();

    /**
     * @return string
     * @field attribute_model
     */
    public function getModelClass();

    /**
     * @return string
     * @field backend_type
     */
    public function getBackendType();

    /**
     * @return string
     * @field backend_model
     */
    public function getBackendModelClass();

    /**
     * @return string
     * @field backend_table
     */
    public function getBackendTable();

    /**
     * @return string
     * @field frontend_model
     */
    public function getFrontendModelClass();

    /**
     * @return string
     * @field frontend_input
     */
    public function getFrontendInput();

    /**
     * @return string
     * @field frontend_label
     */
    public function getFrontendLabel();

    /**
     * @return string
     * @field frontend_class
     */
    public function getFrontendViewClass();

    /**
     * @return string
     * @field source_model
     */
    public function getSourceModelClass();

    /**
     * @return bool
     * @field is_required
     */
    public function isRequired();

    /**
     * @return bool
     * @field is_user_defined
     */
    public function isUserDefined();

    /**
     * @return bool
     */
    public function isSystem();

    /**
     * @return bool
     * @field is_unique
     */
    public function isUnique();

    /**
     * @return string
     * @field default_value
     */
    public function getDefaultValue();

    /**
     * @return string
     * @field note
     */
    public function getNote();
}
