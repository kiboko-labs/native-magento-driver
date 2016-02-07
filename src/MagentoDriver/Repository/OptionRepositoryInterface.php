<?php

namespace Luni\Component\MagentoDriver\Repository;

use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\OptionInterface;

interface OptionRepositoryInterface
{
    /**
     * @param int $id
     * @return OptionInterface
     */
    public function findOneById($id);

    /**
     * @param array|int[] $idList
     * @return Collection|OptionInterface[]
     */
    public function findAllById(array $idList);

    /**
     * @param AttributeInterface $attribute
     * @return Collection|OptionInterface[]
     */
    public function findAllByAttribute(AttributeInterface $attribute);
}