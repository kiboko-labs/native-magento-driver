<?php

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Entity\CategoryInterface;
use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Model\FamilyInterface;

interface ProductRepositoryInterface
{
    /**
     * @param string $code
     *
     * @return ProductInterface
     */
    public function findOneByIdentifier($code);

    /**
     * @param int $identifier
     *
     * @return ProductInterface
     */
    public function findOneById($identifier);

    /**
     * @param array $identifierList
     *
     * @return \Traversable|ProductInterface[]
     */
    public function findAllByIdentifier(array $identifierList);

    /**
     * @param array|int[] $idList
     *
     * @return \Traversable|ProductInterface[]
     */
    public function findAllById(array $idList);

    /**
     * @param FamilyInterface $family
     *
     * @return \Traversable|ProductInterface[]
     */
    public function findAllByFamily(FamilyInterface $family);

    /**
     * @param CategoryInterface $category
     *
     * @return \Traversable|ProductInterface[]
     */
    public function findAllByCategory(CategoryInterface $category);

    /**
     * @return \Traversable|ProductInterface[]
     */
    public function findAll();
}
