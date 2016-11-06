<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Mapper;

interface OptionMapperInterface
{
    /**
     * @param string $code
     *
     * @return int
     */
    public function map($code);

    /**
     * @param string $code
     * @param int    $identifier
     */
    public function persist($code, $identifier);

    public function flush();
}
