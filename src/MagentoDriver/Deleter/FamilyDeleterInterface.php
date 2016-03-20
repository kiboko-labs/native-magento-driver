<?php

namespace Luni\Component\MagentoDriver\Deleter;

interface FamilyDeleterInterface
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