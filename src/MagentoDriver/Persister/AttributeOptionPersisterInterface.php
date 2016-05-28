<?php

namespace Kiboko\Component\MagentoDriver\Persister;

use Kiboko\Component\MagentoDriver\Model\AttributeOptionInterface;

interface AttributeOptionPersisterInterface
{
    public function initialize();

    /**
     * @param AttributeOptionInterface $attributeOption
     */
    public function persist(AttributeOptionInterface $attributeOption);

    /**
     * @param AttributeOptionInterface $attributeOption
     */
    public function __invoke(AttributeOptionInterface $attributeOption);

    public function flush();
}
