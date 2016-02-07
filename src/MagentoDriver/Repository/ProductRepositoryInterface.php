<?php

namespace Luni\Component\MagentoDriver\Repository;

use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Entity\CategoryInterface;
use Luni\Component\MagentoDriver\Entity\ProductInterface;
use Luni\Component\MagentoDriver\Model\FamilyInterface;

interface ProductRepositoryInterface
{
    /**
     * @param string $code
     * @return ProductInterface
     */
    public function findOneByIdentifier($code);

    /**
     * @param int $id
     * @return ProductInterface
     */
    public function findOneById($id);

    /**
     * @param array $identifierList
     * @return Collection|ProductInterface[]
     */
    public function findAllByIdentifier(array $identifierList);

    /**
     * @param array|int[] $idList
     * @return Collection|ProductInterface[]
     */
    public function findAllById(array $idList);

    /**
     * @param FamilyInterface $family
     * @return Collection|ProductInterface[]
     */
    public function findAllByFamily(FamilyInterface $family);

    /**
     * @param CategoryInterface $category
     * @return Collection|ProductInterface[]
     */
    public function findAllByCategory(CategoryInterface $category);

    /**
     * @return Collection|ProductInterface[]
     */
    public function findAll();
}
