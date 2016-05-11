<?php

namespace Luni\Component\MagentoDriver\Deleter;

interface AttributeGroupDeleterInterface
{
    /**
     * @param int $id
     */
    public function deleteOneById($id);

    /**
     * @param int[] $idList
     */
    public function deleteAllById(array $idList);
}
