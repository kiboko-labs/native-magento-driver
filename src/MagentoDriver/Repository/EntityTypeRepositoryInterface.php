<?php

namespace Luni\Component\MagentoDriver\Repository;

use Luni\Component\MagentoDriver\Model\EntityTypeInterface;

interface EntityTypeRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return EntityTypeInterface
     */
    public function findOneById($id);

    /**
     * @param string $code
     *
     * @return EntityTypeInterface
     */
    public function findOneByCode($code);
}
