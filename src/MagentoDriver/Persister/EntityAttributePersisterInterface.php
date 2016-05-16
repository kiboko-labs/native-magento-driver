<?php

namespace Luni\Component\MagentoDriver\Persister;

use Luni\Component\MagentoDriver\Model\EntityAttributeInterface;

interface EntityAttributePersisterInterface
{
    public function initialize();

    /**
     * @param EntityAttributeInterface $entityAttribute
     */
    public function persist(EntityAttributeInterface $entityAttribute);

    /**
     * @param EntityAttributeInterface $entityAttribute
     */
    public function __invoke(EntityAttributeInterface $entityAttribute);

    public function flush();
}
