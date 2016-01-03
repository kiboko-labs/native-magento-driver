<?php

namespace Luni\Component\MagentoDriver\Persister\Attribute;

use Luni\Component\MagentoDriver\Model\AttributeInterface;

interface AttributePersisterInterface
{
    /**
     * @return void
     */
    public function initialize();

    /**
     * @param AttributeInterface $attribute
     */
    public function persist(AttributeInterface $attribute);

    /**
     * @return void
     */
    public function flush();
}