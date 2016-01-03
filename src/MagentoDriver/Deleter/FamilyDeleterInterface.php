<?php

namespace Luni\Component\MagentoDriver\Deleter;

interface FamilyDeleterInterface
{
    /**
     * @param int $id
     */
    public function deleteOneById($id);
}