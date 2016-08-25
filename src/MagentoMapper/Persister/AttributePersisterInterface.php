<?php

namespace Kiboko\Component\MagentoMapper\Persister;

interface AttributePersisterInterface
{
    /**
     * @param string $code
     * @param int $identifier
     */
    public function persist($code, $identifier);
}
