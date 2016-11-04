<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Persister;

use Kiboko\Component\MagentoDriver\Model\AttributeOptionInterface;

interface AttributeOptionPersisterInterface
{
    public function initialize();

    /**
     * @param AttributeOptionInterface $attributeOption
     */
    public function persist(AttributeOptionInterface $attributeOption);

    /**
     * @param AttributeOptionInterface $attributeOption
     */
    public function __invoke(AttributeOptionInterface $attributeOption);

    /**
     * @return \Traversable
     */
    public function flush();
}
