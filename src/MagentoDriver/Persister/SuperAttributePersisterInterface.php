<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Persister;

use Kiboko\Component\MagentoDriver\Model\SuperAttributeInterface;

interface SuperAttributePersisterInterface
{
    public function initialize();

    /**
     * @param SuperAttributeInterface $superAttribute
     */
    public function persist(SuperAttributeInterface $superAttribute);

    /**
     * @param SuperAttributeInterface $superAttribute
     */
    public function __invoke(SuperAttributeInterface $superAttribute);

    /**
     * @return \Traversable
     */
    public function flush();
}
