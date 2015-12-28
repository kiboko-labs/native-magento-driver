<?php

namespace Luni\Component\MagentoDriver\Family;

use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Attribute\AttributeInterface;

interface FamilyInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getLabel();
}