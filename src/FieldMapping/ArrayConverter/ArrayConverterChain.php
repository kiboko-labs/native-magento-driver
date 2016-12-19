<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\FieldMapping\ArrayConverter;

use Akeneo\Component\Batch\Item\ItemProcessorInterface;
use Kiboko\Component\FieldMapping\PriorityChain;
use Pim\Component\Connector\ArrayConverter\ArrayConverterInterface;
use Pim\Component\Connector\Exception\ArrayConversionException;

class ArrayConverterChain implements ArrayConverterInterface
{
    /**
     * @var ArrayConverterInterface[]
     */
    private $converters;

    /**
     * ProcessorStack constructor.
     *
     * @param ArrayConverterInterface[] $converters
     * @param int $priority
     */
    public function __construct(array $converters = [], $priority)
    {
        $this->converters = new PriorityChain();
        $this->converters->attachAll($converters, $priority);
    }

    /**
     * @param ItemProcessorInterface $converter
     * @param int $priority
     */
    public function attach(ItemProcessorInterface $converter, $priority)
    {
        $this->converters->attach($converter, $priority);
    }

    /**
     * @param ItemProcessorInterface[] $converters
     * @param int $priority
     */
    public function attachAll(array $converters, $priority)
    {
        foreach ($converters as $converter) {
            $this->attach($converter, $priority);
        }
    }

    /**
     * @param ItemProcessorInterface $converter
     */
    public function detach(ItemProcessorInterface $converter)
    {
        $this->converters->detach($converter);
    }

    /**
     * @param ItemProcessorInterface[] $converters
     */
    public function detachAll(array $converters)
    {
        foreach ($converters as $converter) {
            $this->detach($converter);
        }
    }

    /**
     * @param array $item    data to convert
     * @param array $options options to use to convert
     *
     * @throws ArrayConversionException
     *
     * @return array
     */
    public function convert(array $item, array $options = [])
    {
        foreach ($this->converters as $converter) {
            $item = $converter->convert($item);
        }
    }
}
