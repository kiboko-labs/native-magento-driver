<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Deleter;

interface AttributeDeleterInterface
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
     * @param string $code
     */
    public function deleteOneByCode($code);

    /**
     * @param string[] $codeList
     */
    public function deleteAllByCode(array $codeList);
}
