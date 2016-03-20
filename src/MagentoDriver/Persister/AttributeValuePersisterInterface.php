<?php

namespace Luni\Component\MagentoDriver\Persister;

use Luni\Component\MagentoDriver\Model\AttributeValueInterface;

interface AttributeValuePersisterInterface
{
    /**
     * @return void
     */
    public function initialize();

    /**
     * @param AttributeValueInterface $value
     */
    public function persist(AttributeValueInterface $value);

    /**
     * @param AttributeValueInterface $value
     * @return mixed
     */
    public function __invoke(AttributeValueInterface $value);

    /**
     * @return void
     */
    public function flush();
}
