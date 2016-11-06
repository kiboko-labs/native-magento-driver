<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Entity\CategoryInterface;

interface CategoryRepositoryInterface
{
    /**
     * @param int $storeId
     *
     * @return CategoryInterface
     */
    public function findRootByStoreId($storeId);

    /**
     * @param string $storeCode
     *
     * @return CategoryInterface
     */
    public function findRootByStoreCode($storeCode);

    /**
     * @param CategoryInterface $parent
     * @param int $depth
     *
     * @return \Traversable
     */
    public function findAllChildren(CategoryInterface $parent, $depth = 1);

    /**
     * @param CategoryInterface $parent
     *
     * @return \Traversable
     */
    public function findAllSiblings(CategoryInterface $parent);

    /**
     * @param CategoryInterface $parent
     *
     * @return \Traversable
     */
    public function findAllParents(CategoryInterface $parent);

    /**
     * @param array $identifiers
     *
     * @return \Traversable
     */
    public function findAllByIdentifier(array $identifiers);

    /**
     * @param CategoryInterface $parent
     *
     * @return \Traversable
     */
    public function findNextSibling(CategoryInterface $parent);

    /**
     * @param CategoryInterface $parent
     *
     * @return \Traversable
     */
    public function findPreviousSibling(CategoryInterface $parent);

    /**
     * @param CategoryInterface $parent
     *
     * @return \Traversable
     */
    public function findParent(CategoryInterface $parent);

    /**
     * @param CategoryInterface $parent
     *
     * @return \Traversable
     */
    public function findFirstChild(CategoryInterface $parent);

    /**
     * @param CategoryInterface $parent
     *
     * @return \Traversable
     */
    public function findLastChild(CategoryInterface $parent);
}
