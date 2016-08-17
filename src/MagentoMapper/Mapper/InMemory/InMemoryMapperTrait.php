<?php

namespace Kiboko\Component\MagentoMapper\Mapper\InMemory;

trait InMemoryMapperTrait
{
    protected $mapping = [];

    /**
     * @param string $identifier
     * @return int
     */
    public function map($identifier)
    {
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
        $this->mapping[$code] = $identifier;
    }
}
