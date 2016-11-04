<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\OptionInterface;

interface OptionRepositoryInterface
{
    /**
     * @param int $identifier
     *
     * @return OptionInterface
     */
    public function findOneById($identifier);

    /**
     * @param array|int[] $idList
     *
     * @return \Traversable|OptionInterface[]
     */
    public function findAllById(array $idList);

    /**
     * @param AttributeInterface $attribute
     *
     * @return \Traversable|OptionInterface[]
     */
    public function findAllByAttribute(AttributeInterface $attribute);
}
