<?php

namespace Luni\Component\MagentoDriver\Persister;

use Luni\Component\MagentoDriver\Model\SuperAttributeInterface;

interface SuperAttributePersisterInterface
{
    /**
     * @return void
     */
    public function initialize();

    /**
     * @param SuperAttributeInterface $superAttribute
     */
    public function persist(SuperAttributeInterface $superAttribute);

    /**
     * @param SuperAttributeInterface $superAttribute
     */
    public function __invoke(SuperAttributeInterface $superAttribute);

    /**
     * @return void
     */
    public function flush();
}