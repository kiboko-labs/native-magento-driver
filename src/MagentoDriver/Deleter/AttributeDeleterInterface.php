<?php

namespace Kiboko\Component\MagentoDriver\Deleter;

interface AttributeDeleterInterface
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
     * @param string $code
     */
    public function deleteOneByCode($code);

    /**
     * @param string[] $codeList
     */
    public function deleteAllByCode(array $codeList);
}
