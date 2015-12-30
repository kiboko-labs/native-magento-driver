<?php

namespace Luni\Component\MagentoDriver\Repository;

use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Entity\FamilyInterface;

interface AttributeRepositoryInterface
{
    /**
     * @param string $code
     * @return AttributeInterface
     */
    public function findOneByCode($code);

    /**
     * @param int $id
     * @return AttributeInterface
     */
    public function findOneById($id);

    /**
     * @param array $codeList
     * @return Collection|AttributeInterface[]
     */
    public function findAllByCode(array $codeList);

    /**
     * @param array|int[] $idList
     * @return Collection|AttributeInterface[]
     */
    public function findAllById(array $idList);

    /**
     * @return Collection|AttributeInterface[]
     */
    public function findAll();
}