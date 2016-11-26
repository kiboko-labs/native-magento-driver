<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

interface IdentifiableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $identifier
     * @internal
     */
    public function persistedToId($identifier);
}
