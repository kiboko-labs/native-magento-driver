<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Model\EntityTypeInterface;

interface EntityTypeRepositoryInterface
{
    /**
     * @param int $identifier
     *
     * @return EntityTypeInterface
     */
    public function findOneById($identifier);

    /**
     * @param string $code
     *
     * @return EntityTypeInterface
     */
    public function findOneByCode($code);

    /**
     * @param array|string[] $codeList
     *
     * @return \Traversable|EntityTypeInterface[]
     */
    public function findAllByCode(array $codeList);

    /**
     * @return \Traversable|EntityTypeInterface[]
     */
    public function findAll();
}
