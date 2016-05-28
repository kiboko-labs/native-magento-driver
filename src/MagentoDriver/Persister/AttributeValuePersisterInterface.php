<?php

namespace Kiboko\Component\MagentoDriver\Persister;

use Kiboko\Component\MagentoDriver\Model\AttributeValueInterface;

interface AttributeValuePersisterInterface
{
    public function initialize();

    /**
     * @param AttributeValueInterface $value
     */
    public function persist(AttributeValueInterface $value);

    /**
     * @param AttributeValueInterface $value
     *
     * @return mixed
     */
    public function __invoke(AttributeValueInterface $value);

    public function flush();
}
