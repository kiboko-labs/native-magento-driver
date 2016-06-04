<?php

namespace Kiboko\Component\MagentoDriver\Repository;

use Doctrine\Common\Collections\Collection;
use Kiboko\Component\MagentoDriver\Model\EntityTypeInterface;

interface EntityTypeRepositoryInterface
{
    /**
     * @param int $identifier
     *
     * @return EntityTypeInterface
     */
    public function findOneById($identifier);

    /**
     * @param string $code
     *
     * @return EntityTypeInterface
     */
    public function findOneByCode($code);

    /**
     * @param array|string[] $codeList
     *
     * @return Collection|EntityTypeInterface[]
     */
    public function findAllByCode(array $codeList);

    /**
     * @return Collection|EntityTypeInterface[]
     */
    public function findAll();
}
