<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister\StandardDml\AttributeValue;

use Kiboko\Component\MagentoORM\Model\AttributeValueInterface;
use Kiboko\Component\MagentoORM\Persister\AttributeValuePersisterInterface;

class StaticAttributeValuePersister implements AttributeValuePersisterInterface
{
    public function initialize()
    {
    }

    /**
     * @param AttributeValueInterface $value
     */
    public function persist(AttributeValueInterface $value)
    {
    }

    /**
     * @return \Traversable
     */
    public function flush()
    {
        return new \ArrayIterator([]);
    }

    /**
     * @param AttributeValueInterface $value
     */
    public function __invoke(AttributeValueInterface $value)
    {
        $this->persist($value);
    }
}
