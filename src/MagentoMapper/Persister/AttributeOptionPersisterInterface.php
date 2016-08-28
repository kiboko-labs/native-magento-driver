<?php

namespace Kiboko\Component\MagentoMapper\Persister;

interface AttributeOptionPersisterInterface
{
    /**
     * @param string $code
     * @param int $identifier
     */
    public function persist($code, $identifier);

    /**
     * @return void
     */
    public function flush();
}
