<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Model\AttributeInterface;

interface AttributeRepositoryInterface
{
    /**
     * @param string $code
     * @param string $entityTypeId
     *
     * @return AttributeInterface
     */
    public function findOneByCode($code, $entityTypeId);

    /**
     * @param int $identifier
     *
     * @return AttributeInterface
     */
    public function findOneById($identifier);

    /**
     * @param string $entityTypeCode
     * @param array  $codeList
     *
     * @return \Traversable|AttributeInterface[]
     */
    public function findAllByCode($entityTypeCode, array $codeList);

    /**
     * @param array|int[] $idList
     *
     * @return \Traversable|AttributeInterface[]
     */
    public function findAllById(array $idList);

    /**
     * @return \Traversable|AttributeInterface[]
     */
    public function findAll();
}
