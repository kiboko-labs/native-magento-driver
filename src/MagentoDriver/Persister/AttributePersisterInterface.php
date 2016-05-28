<?php

namespace Kiboko\Component\MagentoDriver\Persister;

use Kiboko\Component\MagentoDriver\Model\AttributeInterface;

interface AttributePersisterInterface
{
    public function initialize();

    /**
     * @param AttributeInterface $attribute
     */
    public function persist(AttributeInterface $attribute);

    /**
     * @param AttributeInterface $attribute
     */
    public function __invoke(AttributeInterface $attribute);

    public function flush();
}
