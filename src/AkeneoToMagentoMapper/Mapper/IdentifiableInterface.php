<?php

/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Mapper;

interface IdentifiableInterface
{
    /**
     * Set identifier
     *
     * @return string
     */
    public function getIdentifier();
}
