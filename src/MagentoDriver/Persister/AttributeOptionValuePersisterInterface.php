<?php

namespace Kiboko\Component\MagentoDriver\Persister;

use Kiboko\Component\MagentoDriver\Model\AttributeOptionValueInterface;

interface AttributeOptionValuePersisterInterface
{
    public function initialize();

    /**
     * @param AttributeOptionValueInterface $attributeOptionValue
     */
    public function persist(AttributeOptionValueInterface $attributeOptionValue);

    /**
     * @param AttributeOptionValueInterface $attributeOptionValue
     */
    public function __invoke(AttributeOptionValueInterface $attributeOptionValue);

    public function flush();
}
