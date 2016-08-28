<?php

namespace Kiboko\Component\MagentoDriver\Model;

trait IdentifiableTrait
{
    private $identifier;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->identifier;
    }

    /**
     * @param int $identifier
     */
    public function persistedToId($identifier)
    {
        $this->identifier = $identifier;
    }
}
