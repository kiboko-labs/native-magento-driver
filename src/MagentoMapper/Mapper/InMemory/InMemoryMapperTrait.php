<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoMapper\Mapper\InMemory;

use Kiboko\Component\MagentoMapper\Exception\InvalidArgumentException;

/**
 * Class InMemoryMapperTrait.
 *
 * @attribute array $mapping
 */
trait InMemoryMapperTrait
{
    private $unitOfWork = [];

    /**
     * @param string $code
     *
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

        return (int) $this->mapping[$code];
    }

    /**
     * @param string $code
     * @param int    $identifier
     */
    public function persist($code, $identifier)
    {
        $this->unitOfWork[$code] = $identifier;
    }

    public function flush()
    {
        $this->mapping = array_merge(
            $this->mapping,
            $this->unitOfWork
        );

        $this->unitOfWork = [];
    }
}
