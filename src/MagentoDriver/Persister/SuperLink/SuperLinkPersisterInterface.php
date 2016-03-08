<?php

namespace Luni\Component\MagentoDriver\Persister\SuperLink;

use Luni\Component\MagentoDriver\Model\SuperLinkInterface;

interface SuperLinkPersisterInterface
{
    /**
     * @return void
     */
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
     * @return void
     */
    public function flush();
}