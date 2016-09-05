<?php

namespace Kiboko\Component\MagentoMapper\Persister;

interface AttributeGroupPersisterInterface
{
    /**
     * @param string $groupCode
     * @param string $familyCode
     * @param int $identifier
     */
    public function persist($groupCode, $familyCode, $identifier);

    /**
     * @return void
     */
    public function flush();
}
