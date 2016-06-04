<?php

namespace Kiboko\Component\MagentoDriver\Deleter;

interface AttributeGroupDeleterInterface
{
    /**
     * @param int $identifier
     */
    public function deleteOneById($identifier);

    /**
     * @param int[] $idList
     */
    public function deleteAllById(array $idList);
}
