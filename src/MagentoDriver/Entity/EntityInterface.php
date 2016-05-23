<?php

namespace Kiboko\Component\MagentoDriver\Entity;

use Doctrine\Common\Collections\Collection;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeValueInterface;

interface EntityInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return AttributeInterface[]|Collection
     */
    public function getAttributes();

    /**
     * @return AttributeValueInterface[]|Collection
     */
    public function getValues();
}
