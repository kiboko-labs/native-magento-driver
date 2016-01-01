<?php

namespace Luni\Component\MagentoDriver\Repository;

use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Entity\ProductInterface;

interface ProductAttributeValueRepositoryBackendInterface
    extends ProductAttributeValueRepositoryInterface
{
    /**
     * @param int $id
     * @return AttributeValueInterface
     */
    public function findOneById($id);

    /**
     * @param array|int[] $idList
     * @return Collection|AttributeValueInterface[]
     */
    public function findAllById(array $idList);
}