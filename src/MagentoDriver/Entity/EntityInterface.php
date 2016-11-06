<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Entity;

use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeValueInterface;

interface EntityInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return AttributeInterface[]|\Traversable
     */
    public function getAttributes();

    /**
     * @return AttributeValueInterface[]|\Traversable
     */
    public function getValues();
}
