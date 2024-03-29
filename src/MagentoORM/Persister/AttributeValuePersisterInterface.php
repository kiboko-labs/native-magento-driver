<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister;

use Kiboko\Component\MagentoORM\Model\AttributeValueInterface;

interface AttributeValuePersisterInterface
{
    public function initialize();

    /**
     * @param AttributeValueInterface $value
     */
    public function persist(AttributeValueInterface $value);

    /**
     * @param AttributeValueInterface $value
     */
    public function __invoke(AttributeValueInterface $value);

    /**
     * @return \Traversable
     */
    public function flush();
}
