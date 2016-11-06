<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoMapper\Mapper\InMemory;

use Kiboko\Component\MagentoMapper\Exception\InvalidArgumentException;
use Kiboko\Component\MagentoMapper\Mapper\AttributeOptionValueMapperInterface;

class AttributeOptionValueMapper implements AttributeOptionValueMapperInterface
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
     * @param string $code
     * @param string $locale
     * @return int
     */
    public function map($code, $locale)
    {
        if (!is_string($code)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Expecting string type for argument #1, found %s.',
                    is_object($code) ? get_class($code) : gettype($code)
                )
            );
        }

        if (!is_string($locale)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Expecting string type for argument #2, found %s.',
                    is_object($locale) ? get_class($locale) : gettype($locale)
                )
            );
        }

        if (!isset($this->mapping) || !is_array($this->mapping)) {
            $this->mapping = [];
        }

        if (!isset($this->mapping[$code][$locale])) {
            return;
        }

        return $this->mapping[$code][$locale];
    }

    /**
     * @param string $code
     * @param string $locale
     * @param int $identifier
     */
    public function persist($code, $locale, $identifier)
    {
        if (!isset($this->mapping)) {
            $this->mapping = [];
        }
        if (!isset($this->mapping[$locale])) {
            $this->mapping[$locale] = [];
        }

        $this->mapping[$code][$locale] = $identifier;
    }
}
