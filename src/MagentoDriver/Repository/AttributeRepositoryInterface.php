<?php

namespace Kiboko\Component\MagentoDriver\Repository;

use Doctrine\Common\Collections\Collection;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;

interface AttributeRepositoryInterface
{
    /**
     * @param string $code
     * @param string $entityTypeId
     *
     * @return AttributeInterface
     */
    public function findOneByCode($code, $entityTypeId);

    /**
     * @param int $identifier
     *
     * @return AttributeInterface
     */
    public function findOneById($identifier);

    /**
     * @param string $entityTypeCode
     * @param array  $codeList
     *
     * @return Collection|AttributeInterface[]
     */
    public function findAllByCode($entityTypeCode, array $codeList);

    /**
     * @param array|int[] $idList
     *
     * @return Collection|AttributeInterface[]
     */
    public function findAllById(array $idList);

    /**
     * @return Collection|AttributeInterface[]
     */
    public function findAll();
}
