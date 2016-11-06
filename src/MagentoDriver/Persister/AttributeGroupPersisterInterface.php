<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Persister;

use Kiboko\Component\MagentoDriver\Model\AttributeGroupInterface;

interface AttributeGroupPersisterInterface
{
    public function initialize();

    /**
     * @param AttributeGroupInterface $attributeGroup
     */
    public function persist(AttributeGroupInterface $attributeGroup);

    /**
     * @param AttributeGroupInterface $attributeGroup
     */
    public function __invoke(AttributeGroupInterface $attributeGroup);

    /**
     * @return \Traversable
     */
    public function flush();
}
