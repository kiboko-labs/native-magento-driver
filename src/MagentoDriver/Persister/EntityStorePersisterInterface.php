<?php

namespace Kiboko\Component\MagentoDriver\Persister;

use Kiboko\Component\MagentoDriver\Model\EntityStoreInterface;

interface EntityStorePersisterInterface
{
    public function initialize();

    /**
     * @param EntityStoreInterface $entityStore
     */
    public function persist(EntityStoreInterface $entityStore);

    /**
     * @param EntityStoreInterface $entityStore
     */
    public function __invoke(EntityStoreInterface $entityStore);

    /**
     * @return \Traversable
     */
    public function flush();
}
