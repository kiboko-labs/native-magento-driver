<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Persister;

interface AttributeGroupPersisterInterface
{
    /**
     * @param string $groupCode
     * @param string $familyCode
     * @param int    $identifier
     */
    public function persist($groupCode, $familyCode, $identifier);

    public function flush();
}
