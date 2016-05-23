<?php

namespace Kiboko\Component\MagentoDriver\Deleter;

interface AttributeOptionValueDeleterInterface
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
