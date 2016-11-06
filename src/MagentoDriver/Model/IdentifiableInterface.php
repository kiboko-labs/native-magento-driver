<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model;

interface IdentifiableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $identifier
     */
    public function persistedToId($identifier);
}
