<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister;

use Kiboko\Component\MagentoORM\Model\SuperLinkInterface;

interface SuperLinkPersisterInterface
{
    public function initialize();

    /**
     * @param SuperLinkInterface $superLink
     */
    public function persist(SuperLinkInterface $superLink);

    /**
     * @param SuperLinkInterface $superLink
     */
    public function __invoke(SuperLinkInterface $superLink);

    /**
     * @return \Traversable
     */
    public function flush();
}
