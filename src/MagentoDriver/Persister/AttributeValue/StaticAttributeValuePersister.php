<?php

namespace Luni\Component\MagentoDriver\Persister\AttributeValue;

use Luni\Component\MagentoDriver\Model\AttributeValueInterface;

class StaticAttributeValuePersister
    implements AttributeValuePersisterInterface
{
    /**
     *
     */
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
     * @param AttributeValueInterface $value
     * @return void
     */
    public function __invoke(AttributeValueInterface $value)
    {
        $this->persist($value);
    }

    public function flush()
    {
    }

    protected function walkQueue()
    {
    }
}
