<?php

namespace Luni\Component\MagentoDriver\Model;

interface AttributeInterface
{
    /**
     * @return int
     * @MagentoODM\Field('attribute_id', version='*')
     */
    public function getId();

    /**
     * @param int $id
     */
    public function persistedToId($id);

    /**
     * @return int
     * @MagentoODM\Field('entity_type_id', version='*')
     */
    public function getEntityTypeId();

    /**
     * @return string
     * @MagentoODM\Field('attribute_code', version='*')
     */
    public function getCode();

    /**
     * @return string
     * @MagentoODM\Field('attribute_model', version='*')
     */
    public function getModelClass();

    /**
     * @return string
     * @MagentoODM\Field('backend_type', version='*')
     */
    public function getBackendType();

    /**
     * @return string
     * @MagentoODM\Field('backend_model', version='*')
     */
    public function getBackendModelClass();

    /**
     * @return string
     * @MagentoODM\Field('backend_table', version='*')
     */
    public function getBackendTable();

    /**
     * @return string
     * @MagentoODM\Field('frontend_model', version='*')
     */
    public function getFrontendModelClass();

    /**
     * @return string
     * @MagentoODM\Field('frontend_input', version='*')
     */
    public function getFrontendInput();

    /**
     * @return string
     * @MagentoODM\Field('frontend_label', version='*')
     */
    public function getFrontendLabel();

    /**
     * @return string
     * @MagentoODM\Field('frontend_class', version='*')
     */
    public function getFrontendViewClass();

    /**
     * @return string
     * @MagentoODM\Field('source_model', version='*')
     */
    public function getSourceModelClass();

    /**
     * @return bool
     * @MagentoODM\Field('is_required', version='*')
     */
    public function isRequired();

    /**
     * @return bool
     * @MagentoODM\Field('is_user_defined', version='*')
     */
    public function isUserDefined();

    /**
     * @return bool
     */
    public function isSystem();

    /**
     * @return bool
     * @MagentoODM\Field('is_unique', version='*')
     */
    public function isUnique();

    /**
     * @return string
     * @MagentoODM\Field('default_value', version='*')
     */
    public function getDefaultValue();

    /**
     * @return string
     * @MagentoODM\Field('note', version='*')
     */
    public function getNote();
}
