<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface IdentifiableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $identifier
     */
    public function persistedToId($identifier);
}
