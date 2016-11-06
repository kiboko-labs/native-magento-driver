<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Deleter;

interface ProductDeleterInterface
{
    /**
     * @param int $identifier
     */
    public function deleteOneById($identifier);

    /**
     * @param int[] $idList
     */
    public function deleteAllById(array $idList);

    /**
     * @param int $identifier
     */
    public function deleteOneByIdentifier($identifier);

    /**
     * @param int[] $skuList
     */
    public function deleteAllByIdentifier(array $skuList);
}
