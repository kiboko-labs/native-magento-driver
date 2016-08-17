<?php

namespace Kiboko\Component\MagentoMapper\Persister;

interface AttributePersisterInterface
{
    /**
     * @param int $code
     * @param string $identifier
     */
    public function persist($code, $identifier);
}
