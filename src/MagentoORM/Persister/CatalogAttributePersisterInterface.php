<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister;

use Kiboko\Component\MagentoORM\Model\CatalogAttributeInterface;

interface CatalogAttributePersisterInterface
{
    public function initialize();

    /**
     * @param CatalogAttributeInterface $attribute
     */
    public function persist(CatalogAttributeInterface $attribute);

    /**
     * @param CatalogAttributeInterface $attribute
     */
    public function __invoke(CatalogAttributeInterface $attribute);

    /**
     * @return \Traversable
     */
    public function flush();
}
