<?php

namespace Luni\Component\MagentoDriver\Deleter;

interface CatalogAttributeDeleterInterface
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