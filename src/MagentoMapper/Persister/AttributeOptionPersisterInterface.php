<?php

namespace Kiboko\Component\MagentoMapper\Persister;

interface AttributeOptionPersisterInterface
{
    /**
     * @param int $code
     * @param string $identifier
     */
    public function persist($code, $identifier);
}
