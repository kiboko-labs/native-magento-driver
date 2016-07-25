<?php

namespace Kiboko\Component\MagentoDriver\Model;

class AttributeGroup implements AttributeGroupInterface
{
    /**
     * @var int
     */
    private $identifier;

    /**
     * @var int
     */
    private $familyId;

    /**
     * @var string
     */
    private $label;

    /**
     * @var int
     */
    private $sortOrder;

    /**
     * @var int
     */
    private $defaultId;
    
    /**
     * @var string
     */
    private $attributeGroupCode;
    
    /**
     * @var string
     */
    private $tabGroupCode;

    /**
     * @param int    $familyId
     * @param string $label
     * @param int    $sortOrder
     * @param int    $defaultId
     * @param string $attributeGroupCode
     * @param string $tabGroupCode
     */
    public function __construct(
        $familyId,
        $label,
        $sortOrder = 1,
        $defaultId = 0,
        $attributeGroupCode = null,
        $tabGroupCode = null    
    ) {
        switch($GLOBALS['MAGENTO_VERSION']){
            case '2.0':
                $this->magento2x__construct($familyId, $label, $sortOrder, $defaultId, $attributeGroupCode, $tabGroupCode);
                break;
            default:
                $this->magento19x__construct($familyId, $label, $sortOrder, $defaultId);
                break;
        }
    }
    
    private function magento19x__construct(
        $familyId, 
        $label, 
        $sortOrder = 1, 
        $defaultId = 0
    ) {
        $this->familyId = $familyId;
        $this->label = $label;
        $this->sortOrder = $sortOrder;
        $this->defaultId = $defaultId;
    }

    private function magento2x__construct(
        $familyId,
        $label,
        $sortOrder = 1,
        $defaultId = 0,
        $attributeGroupCode,
        $tabGroupCode = null 
    ){
        $this->magento19x__construct($familyId, $label, $sortOrder,$defaultId);
        $this->attributeGroupCode = $attributeGroupCode;
        $this->tabGroupCode = $tabGroupCode;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->identifier;
    }

    /**
     * @return int
     */
    public function getFamilyId()
    {
        return $this->familyId;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return int
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @return int
     */
    public function getDefaultId()
    {
        return $this->defaultId;
    }
    
    /**
     * @return string
     */
    public function getAttributeGroupCode()
    {
        return $this->attributeGroupCode;
    }
    
    /**
     * @return string
     */
    public function getTabGroupCode()
    {
        return $this->tabGroupCode;
    }

    /**
     * @param int    $attributeGroupId
     * @param int    $familyId
     * @param string $label
     * @param int    $sortOrder
     * @param int    $defaultId
     * @param string $attributeGroupCode
     * @param string $tabGroupCode
     */
    public static function buildNewWith(
        $attributeGroupId,
        $familyId,
        $label,
        $sortOrder = 1,
        $defaultId = 0,
        $attributeGroupCode = null,
        $tabGroupCode = null 
    ) {
        
        switch($GLOBALS['MAGENTO_VERSION']){
            case '2.0':
                return self::magento2xBuildNewWith($attributeGroupId, $familyId, $label, $sortOrder, $defaultId, $attributeGroupCode, $tabGroupCode);
            default:
                return self::magento19xBuildNewWith($attributeGroupId, $familyId, $label, $sortOrder, $defaultId);
        }
    }
    
    /**
     * @param int    $attributeGroupId
     * @param int    $familyId
     * @param string $label
     * @param int    $sortOrder
     * @param int    $defaultId
     *
     * @return AttributeGroupInterface
     */
    private static function magento19xBuildNewWith($attributeGroupId, $familyId, $label, $sortOrder, $defaultId){
        $object = new static($familyId, $label, $sortOrder, $defaultId);

        $object->identifier = $attributeGroupId;

        return $object;
    }
    
    /**
     * @param int    $attributeGroupId
     * @param int    $familyId
     * @param string $label
     * @param int    $sortOrder
     * @param int    $defaultId
     * @param string $attributeGroupCode
     * @param string $tabGroupCode
     *
     * @return AttributeGroupInterface
     */
    private static function magento2xBuildNewWith($attributeGroupId, $familyId, $label, $sortOrder, $defaultId, $attributeGroupCode, $tabGroupCode){
        $object = new static($familyId, $label, $sortOrder, $defaultId, $attributeGroupCode, $tabGroupCode);

        $object->identifier = $attributeGroupId;

        return $object;
    }

    /**
     * @param int $identifier
     */
    public function persistedToId($identifier)
    {
        $this->identifier = $identifier;
    }
}
