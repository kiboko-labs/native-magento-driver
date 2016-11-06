<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister;

use Kiboko\Component\MagentoORM\Model\AttributeLabelInterface;

interface AttributeLabelPersisterInterface
{
    public function initialize();

    /**
     * @param AttributeLabelInterface $attributeLabel
     */
    public function persist(AttributeLabelInterface $attributeLabel);

    /**
     * @param AttributeLabelInterface $attributeLabel
     */
    public function __invoke(AttributeLabelInterface $attributeLabel);

    /**
     * @return \Traversable
     */
    public function flush();
}
