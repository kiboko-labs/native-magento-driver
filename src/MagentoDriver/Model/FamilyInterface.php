<?php

namespace Luni\Component\MagentoDriver\Model;

use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Model\AttributeInterface;

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