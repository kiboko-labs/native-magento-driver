<?php

namespace Luni\Component\MagentoDriver\Persister;

use Luni\Component\MagentoDriver\Model\FamilyInterface;

interface FamilyPersisterInterface
{
    public function initialize();

    /**
     * @param FamilyInterface $family
     */
    public function persist(FamilyInterface $family);

    /**
     * @param FamilyInterface $family
     */
    public function __invoke(FamilyInterface $family);

    public function flush();
}
