<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Mapper;

interface EntityTypeCodeMapperInterface
{
    /**
     * @param string $code
     *
     * @return string
     */
    public function map($code);

    /**
     * @param string $akeneoCode
     * @param string $magentoCode
     */
    public function persist($akeneoCode, $magentoCode);

    public function flush();
}
