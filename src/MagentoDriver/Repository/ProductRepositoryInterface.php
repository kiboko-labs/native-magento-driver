<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Entity\CategoryInterface;
use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Model\FamilyInterface;

interface ProductRepositoryInterface
{
    /**
     * @param string $identifier
     *
     * @return ProductInterface
     */
    public function findOneById($identifier);

    /**
     * @param int $code
     *
     * @return ProductInterface
     */
    public function findOneByIdentifier($code);

    /**
     * @param array $identifierList
     *
     * @return \Traversable|ProductInterface[]
     */
    public function findAllById(array $identifierList);

    /**
     * @param array|int[] $codeList
     *
     * @return \Traversable|ProductInterface[]
     */
    public function findAllByIdentifier(array $codeList);

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
