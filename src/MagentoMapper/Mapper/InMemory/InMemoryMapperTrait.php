<?php

namespace Kiboko\Component\MagentoMapper\Mapper\InMemory;

/**
 * Class InMemoryMapperTrait
 * @package Kiboko\Component\MagentoMapper\Mapper\InMemory
 *
 * @attribute array $mapping
 */
trait InMemoryMapperTrait
{
    /**
     * @param string $identifier
     * @return int
     */
    public function map($identifier)
    {
        if (!isset($this->mapping)) {
            $this->mapping = [];
        }

        if (!isset($this->mapping[$identifier])) {
            return;
        }

        return $this->mapping[$identifier];
    }

    /**
     * @param string $code
     * @param int $identifier
     */
    public function persist($code, $identifier)
    {
        if (!isset($this->mapping)) {
            $this->mapping = [];
        }

        $this->mapping[$code] = $identifier;
    }
}
