<?php

namespace Kiboko\Component\MagentoDriver\Persister;

use Kiboko\Component\MagentoDriver\Entity\CategoryInterface;

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

    /**
     * @return \Traversable
     */
    public function flush();
}
