<?php

namespace Luni\Component\MagentoDriver\Entity;

use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\AttributeValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\Immutable\ImmutableVarcharAttributeValue;

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