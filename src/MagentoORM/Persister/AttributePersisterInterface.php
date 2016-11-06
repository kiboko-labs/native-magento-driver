<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister;

use Kiboko\Component\MagentoORM\Model\AttributeInterface;

interface AttributePersisterInterface
{
    public function initialize();

    /**
     * @param AttributeInterface $attribute
     */
    public function persist(AttributeInterface $attribute);

    /**
     * @param AttributeInterface $attribute
     */
    public function __invoke(AttributeInterface $attribute);

    /**
     * @return \Traversable
     */
    public function flush();
}
