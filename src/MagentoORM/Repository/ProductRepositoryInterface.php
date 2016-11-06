<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository;

use Kiboko\Component\MagentoORM\Entity\CategoryInterface;
use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoORM\Model\FamilyInterface;

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
