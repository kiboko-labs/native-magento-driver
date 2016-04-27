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

    /**
     * @param string $entityTypeCode
     * @param array  $codeList
     *
     * @return Collection|EntityTypeInterface[]
     */
    public function findAllByCode($entityTypeCode, array $codeList);

    /**
     * @param array|int[] $idList
     *
     * @return Collection|EntityTypeInterface[]
     */
    public function findAllById(array $idList);

    /**
     * @return Collection|EntityTypeInterface[]
     */
    public function findAll();
}
