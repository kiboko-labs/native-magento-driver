<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository;

use Kiboko\Component\MagentoORM\Model\AttributeValueInterface;

interface ProductAttributeValueRepositoryBackendInterface extends ProductAttributeValueRepositoryInterface
{
    /**
     * @param int $identifier
     *
     * @return AttributeValueInterface
     */
    public function findOneById($identifier);

    /**
     * @param array|int[] $idList
     *
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllById(array $idList);
}
