<?php

namespace Kiboko\Component\MagentoMapper\Mapper\InMemory;
use Kiboko\Component\MagentoMapper\Exception\InvalidArgumentException;

/**
 * Class InMemoryMapperTrait
 * @package Kiboko\Component\MagentoMapper\Mapper\InMemory
 *
 * @attribute array $mapping
 */
trait InMemoryMapperTrait
{
    /**
     * @param string $code
     * @return int
     */
    public function map($code)
    {
        if (!is_string($code)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Expecting string type for argument #1, found %s.',
                    is_object($code) ? get_class($code) : gettype($code)
                )
            );
        }
        
        if (!isset($this->mapping) || !is_array($this->mapping)) {
            $this->mapping = [];
        }

        if (!isset($this->mapping[$code])) {
            return;
        }

        return $this->mapping[$code];
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
