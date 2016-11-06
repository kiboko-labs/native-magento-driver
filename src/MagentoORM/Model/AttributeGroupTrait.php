<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

trait AttributeGroupTrait
{
    use ParentMappableTrait;
    use IdentifiableTrait;

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
}
