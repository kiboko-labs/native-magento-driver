<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Persister;

use Kiboko\Component\MagentoDriver\Model\FamilyInterface;

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

    /**
     * @return \Traversable
     */
    public function flush();
}
