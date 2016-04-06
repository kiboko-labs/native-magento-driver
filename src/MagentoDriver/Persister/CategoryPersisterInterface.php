<?php

namespace Luni\Component\MagentoDriver\Persister;

use Luni\Component\MagentoDriver\Entity\CategoryInterface;

interface CategoryPersisterInterface
{
    public function initialize();

    /**
     * @param CategoryInterface $category
     */
    public function persist(CategoryInterface $category);

    /**
     * @param CategoryInterface $category
     */
    public function __invoke(CategoryInterface $category);

    public function flush();
}
