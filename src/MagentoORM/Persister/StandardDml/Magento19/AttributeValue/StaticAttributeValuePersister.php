<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister\StandardDml\Magento19\AttributeValue;

use Kiboko\Component\MagentoORM\Exception\InvalidAttributePersisterTypeException;
use Kiboko\Component\MagentoORM\Model\AttributeValueInterface as BaseAttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\Magento19\AttributeValueInterface;
use Kiboko\Component\MagentoORM\Persister\AttributeValuePersisterInterface;

class StaticAttributeValuePersister implements AttributeValuePersisterInterface
{
    public function initialize()
    {
    }

    /**
     * @param BaseAttributeValueInterface $value
     */
    public function persist(BaseAttributeValueInterface $value)
    {
        if (!$value instanceof AttributeValueInterface) {
            throw new InvalidAttributePersisterTypeException(sprintf(
                'Invalid attribute value type, expected "%s", got "%s".',
                BaseAttributeValueInterface::class,
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }
    }

    /**
     * @return \Traversable
     */
    public function flush()
    {
        return new \ArrayIterator([]);
    }

    /**
     * @param BaseAttributeValueInterface $value
     */
    public function __invoke(BaseAttributeValueInterface $value)
    {
        $this->persist($value);
    }
}
