<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model;

class OptionLocale implements OptionLocaleInterface
{
    use MappableTrait;

    /**
     * @var string
     */
    private $label;

    /**
     * @var int
     */
    private $storeId;

    /**
     * @param string   $label
     * @param null|int $storeId
     */
    public function __construct($label, $storeId = null)
    {
        $this->label = $label;
        $this->storeId = $storeId;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return int|null
     */
    public function getStoreId()
    {
        return $this->storeId;
    }
}
