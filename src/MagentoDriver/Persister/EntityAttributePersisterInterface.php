<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Persister;

use Kiboko\Component\MagentoDriver\Model\EntityAttributeInterface;

interface EntityAttributePersisterInterface
{
    public function initialize();

    /**
     * @param EntityAttributeInterface $entityAttribute
     */
    public function persist(EntityAttributeInterface $entityAttribute);

    /**
     * @param EntityAttributeInterface $entityAttribute
     */
    public function __invoke(EntityAttributeInterface $entityAttribute);

    /**
     * @return \Traversable
     */
    public function flush();
}
