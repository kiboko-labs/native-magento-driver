<?php

namespace Kiboko\Component\MagentoDriver\Model;

class Attribute implements AttributeInterface
{
    /**
     * @var int
     */
    private $identifier;

    /**
     * @var int
     */
    private $entityTypeId;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $modelClass;

    /**
     * @var string
     */
    private $backendType;

    /**
     * @var string
     */
    private $backendModelClass;

    /**
     * @var string
     */
    private $backendTable;

    /**
     * @var string
     */
    private $frontendModelClass;

    /**
     * @var string
     */
    private $frontendInput;

    /**
     * @var string
     */
    private $frontendLabel;

    /**
     * @var string
     */
    private $frontendViewClass;

    /**
     * @var string
     */
    private $sourceModelClass;

    /**
     * @var bool
     */
    private $required;

    /**
     * @var bool
     */
    private $userDefined;

    /**
     * @var bool
     */
    private $unique;

    /**
     * @var string
     */
    private $defaultValue;

    /**
     * @var string
     */
    private $note;

    /**
     * @param int    $entityTypeId
     * @param string $code
     * @param string $modelClass
     * @param string $backendType
     * @param string $backendModelClass
     * @param string $backendTable
     * @param string $frontendModelClass
     * @param string $frontendInput
     * @param string $frontendLabel
     * @param string $frontendViewClass
     * @param string $sourceModelClass
     * @param bool   $required
     * @param bool   $userDefined
     * @param bool   $unique
     * @param string $defaultValue
     * @param string $note
     */
    public function __construct(
        $entityTypeId,
        $code,
        $modelClass,
        $backendType,
        $backendModelClass,
        $backendTable,
        $frontendModelClass,
        $frontendInput,
        $frontendLabel,
        $frontendViewClass,
        $sourceModelClass,
        $required,
        $userDefined,
        $unique,
        $defaultValue,
        $note = null
    ) {
        $this->entityTypeId = $entityTypeId;
        $this->code = $code;
        $this->modelClass = $modelClass;
        $this->backendType = $backendType;
        $this->backendModelClass = $backendModelClass;
        $this->backendTable = $backendTable;
        $this->frontendModelClass = $frontendModelClass;
        $this->frontendInput = $frontendInput;
        $this->frontendLabel = $frontendLabel;
        $this->frontendViewClass = $frontendViewClass;
        $this->sourceModelClass = $sourceModelClass;
        $this->required = (bool) $required;
        $this->userDefined = (bool) $userDefined;
        $this->unique = (bool) $unique;
        $this->defaultValue = $defaultValue;
        $this->note = $note;
    }

    /**
     * @param int    $attributeId
     * @param int    $entityTypeId
     * @param string $code
     * @param string $modelClass
     * @param string $backendType
     * @param string $backendModelClass
     * @param string $backendTable
     * @param string $frontendModelClass
     * @param string $frontendInput
     * @param string $frontendLabel
     * @param string $frontendViewClass
     * @param string $sourceModelClass
     * @param bool   $required
     * @param bool   $userDefined
     * @param bool   $unique
     * @param string $defaultValue
     * @param string $note
     *
     * @return AttributeInterface
     */
    public static function buildNewWith(
        $attributeId,
        $entityTypeId,
        $code,
        $modelClass,
        $backendType,
        $backendModelClass,
        $backendTable,
        $frontendModelClass,
        $frontendInput,
        $frontendLabel,
        $frontendViewClass,
        $sourceModelClass,
        $required,
        $userDefined,
        $unique,
        $defaultValue,
        $note = null
    ) {
        $object = new self(
            $entityTypeId,
            $code,
            $modelClass,
            $backendType,
            $backendModelClass,
            $backendTable,
            $frontendModelClass,
            $frontendInput,
            $frontendLabel,
            $frontendViewClass,
            $sourceModelClass,
            $required,
            $userDefined,
            $unique,
            $defaultValue,
            $note
        );

        $object->id = $attributeId;

        return $object;
    }

    /**
     * @return int
     * @MagentoODM\Field('attribute_id', version='*')
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $identifier
     */
    public function persistedToId($identifier)
    {
        $this->id = $identifier;
    }

    /**
     * @return int
     * @MagentoODM\Field('entity_type_id', version='*')
     */
    public function getEntityTypeId()
    {
        return $this->entityTypeId;
    }

    /**
     * @return string
     * @MagentoODM\Field('attribute_code', version='*')
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     * @MagentoODM\Field('attribute_model', version='*')
     */
    public function getModelClass()
    {
        return $this->modelClass;
    }

    /**
     * @return string
     * @MagentoODM\Field('backend_type', version='*')
     */
    public function getBackendType()
    {
        return $this->backendType;
    }

    /**
     * @return string
     * @MagentoODM\Field('backend_model', version='*')
     */
    public function getBackendModelClass()
    {
        return $this->backendModelClass;
    }

    /**
     * @return string
     * @MagentoODM\Field('backend_table', version='*')
     */
    public function getBackendTable()
    {
        return $this->backendTable;
    }

    /**
     * @return string
     * @MagentoODM\Field('frontend_model', version='*')
     */
    public function getFrontendModelClass()
    {
        return $this->frontendModelClass;
    }

    /**
     * @return string
     * @MagentoODM\Field('frontend_input', version='*')
     */
    public function getFrontendInput()
    {
        return $this->frontendInput;
    }

    /**
     * @return string
     * @MagentoODM\Field('frontend_label', version='*')
     */
    public function getFrontendLabel()
    {
        return $this->frontendLabel;
    }

    /**
     * @return string
     * @MagentoODM\Field('frontend_class', version='*')
     */
    public function getFrontendViewClass()
    {
        return $this->frontendViewClass;
    }

    /**
     * @return string
     * @MagentoODM\Field('source_model', version='*')
     */
    public function getSourceModelClass()
    {
        return $this->sourceModelClass;
    }

    /**
     * @return bool
     * @MagentoODM\Field('is_required', version='*')
     */
    public function isRequired()
    {
        return (bool) $this->required;
    }

    /**
     * @return bool
     * @MagentoODM\Field('is_user_defined', version='*')
     */
    public function isUserDefined()
    {
        return (bool) $this->userDefined;
    }

    /**
     * @return bool
     */
    public function isSystem()
    {
        return (bool) !$this->userDefined;
    }

    /**
     * @return bool
     * @MagentoODM\Field('is_unique', version='*')
     */
    public function isUnique()
    {
        return (bool) $this->unique;
    }

    /**
     * @return string
     * @MagentoODM\Field('default_value', version='*')
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @return string
     * @MagentoODM\Field('note', version='*')
     */
    public function getNote()
    {
        return $this->note;
    }
}
