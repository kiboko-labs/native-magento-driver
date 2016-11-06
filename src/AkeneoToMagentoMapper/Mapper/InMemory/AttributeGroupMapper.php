<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Mapper\InMemory;

use Kiboko\Component\AkeneoToMagentoMapper\Exception\InvalidArgumentException;
use Kiboko\Component\AkeneoToMagentoMapper\Mapper\AttributeGroupMapperInterface;

class AttributeGroupMapper implements AttributeGroupMapperInterface
{
    use InMemoryMapperTrait;

    protected $mapping = [];

    /**
     * @param array|null $mapping
     */
    public function __construct(
        array $mapping = null
    ) {
        if ($mapping !== null) {
            $this->mapping = $mapping;
        }
    }

    /**
     * @param string $groupCode
     * @param string $familyCode
     *
     * @return int
     */
    public function map($groupCode, $familyCode)
    {
        if (!is_string($groupCode)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Expecting string type for argument #1, found %s.',
                    is_object($groupCode) ? get_class($groupCode) : gettype($groupCode)
                )
            );
        }

        if (!is_string($familyCode)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Expecting string type for argument #2, found %s.',
                    is_object($familyCode) ? get_class($familyCode) : gettype($familyCode)
                )
            );
        }

        if (!isset($this->mapping) || !is_array($this->mapping)) {
            $this->mapping = [];
        }

        if (!isset($this->mapping[$groupCode][$familyCode])) {
            return;
        }

        return $this->mapping[$groupCode][$familyCode];
    }

    /**
     * @param string $groupCode
     * @param string $familyCode
     * @param int    $identifier
     */
    public function persist($groupCode, $familyCode, $identifier)
    {
        if (!isset($this->mapping)) {
            $this->mapping = [];
        }
        if (!isset($this->mapping[$familyCode])) {
            $this->mapping[$familyCode] = [];
        }

        $this->mapping[$groupCode][$familyCode] = $identifier;
    }
}
