<?php

namespace Kiboko\Component\MagentoDriver\Repository;

use Doctrine\Common\Collections\Collection;
use Kiboko\Component\MagentoDriver\Model\AttributeValueInterface;

interface ProductAttributeValueRepositoryBackendInterface extends ProductAttributeValueRepositoryInterface
{
    /**
     * @param int $identifier
     *
     * @return AttributeValueInterface
     */
    public function findOneById($identifier);

    /**
     * @param array|int[] $idList
     *
     * @return Collection|AttributeValueInterface[]
     */
    public function findAllById(array $idList);
}
