<?php

namespace Kiboko\Component\MagentoDriver\Deleter;

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
