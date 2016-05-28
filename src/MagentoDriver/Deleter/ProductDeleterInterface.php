<?php

namespace Kiboko\Component\MagentoDriver\Deleter;

interface ProductDeleterInterface
{
    /**
     * @param int $id
     */
    public function deleteOneById($id);

    /**
     * @param int[] $idList
     */
    public function deleteAllById(array $idList);

    /**
     * @param int $id
     */
    public function deleteOneByIdentifier($id);

    /**
     * @param int[] $skuList
     */
    public function deleteAllByIdentifier(array $skuList);
}
