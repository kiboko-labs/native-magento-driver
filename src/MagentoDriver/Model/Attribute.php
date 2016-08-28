<?php

namespace Kiboko\Component\MagentoDriver\Model;

class Attribute implements AttributeInterface
{
    use MappableTrait;

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
     * @return int
     */
    public function getEntityTypeId()
    {
        return $this->entityTypeId;
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
    public function getModelClass()
    {
        return $this->modelClass;
    }

    /**
     * @return string
     */
    public function getBackendType()
    {
        return $this->backendType;
    }

    /**
     * @return string
     */
    public function getBackendModelClass()
    {
        return $this->backendModelClass;
    }

    /**
     * @return string
     */
    public function getBackendTable()
    {
        return $this->backendTable;
    }

    /**
     * @return string
     */
    public function getFrontendModelClass()
    {
        return $this->frontendModelClass;
    }

    /**
     * @return string
     */
    public function getFrontendInput()
    {
        return $this->frontendInput;
    }

    /**
     * @return string
     */
    public function getFrontendLabel()
    {
        return $this->frontendLabel;
    }

    /**
     * @return string
     */
    public function getFrontendViewClass()
    {
        return $this->frontendViewClass;
    }

    /**
     * @return string
     */
    public function getSourceModelClass()
    {
        return $this->sourceModelClass;
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        return (bool) $this->required;
    }

    /**
     * @return bool
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
     */
    public function isUnique()
    {
        return (bool) $this->unique;
    }

    /**
     * @return string
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
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

        $object->persistedToId($attributeId);

        return $object;
    }
}
