<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Mapper;

interface AttributeGroupMapperInterface
{
    /**
     * @param string $groupCode
     * @param string $familyCode
     *
     * @return int
     */
    public function map($groupCode, $familyCode);

    /**
     * @param string $groupCode
     * @param string $familyCode
     * @param int    $identifier
     */
    public function persist($groupCode, $familyCode, $identifier);

    public function flush();
}
