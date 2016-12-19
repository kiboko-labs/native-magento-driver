<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister\V1_9ce;

use Kiboko\Component\MagentoORM\Model\V1_9ce\CatalogAttributeInterface;
use Kiboko\Component\MagentoORM\Persister\AttributePersisterInterface;
use Kiboko\Component\MagentoORM\Persister\CatalogAttributeExtensionPersisterInterface;

class CatalogAttributePersister implements CatalogAttributePersisterInterface
{
    /**
     * @var AttributePersisterInterface
     */
    protected $standardAttributePersister;

    /**
     * @var CatalogAttributeExtensionPersisterInterface
     */
    protected $catalogAttributeExtensionPersister;

    /**
     * @param AttributePersisterInterface                 $standardAttributePersister
     * @param CatalogAttributeExtensionPersisterInterface $catalogAttributeExtensionPersister
     */
    public function __construct(
        AttributePersisterInterface $standardAttributePersister,
        CatalogAttributeExtensionPersisterInterface $catalogAttributeExtensionPersister
    ) {
        $this->standardAttributePersister = $standardAttributePersister;
        $this->catalogAttributeExtensionPersister = $catalogAttributeExtensionPersister;
    }

    public function initialize()
    {
        $this->standardAttributePersister->initialize();
        $this->catalogAttributeExtensionPersister->initialize();
    }

    /**
     * @param CatalogAttributeInterface $attribute
     */
    public function persist(CatalogAttributeInterface $attribute)
    {
        $this->standardAttributePersister->persist($attribute);
        $this->catalogAttributeExtensionPersister->persist($attribute);
    }

    /**
     * @return \Traversable
     */
    public function flush()
    {
        foreach ($this->standardAttributePersister->flush() as $item) {
            yield $item;
        }
        iterator_count($this->catalogAttributeExtensionPersister->flush());
    }

    /**
     * @param CatalogAttributeInterface $attribute
     */
    public function __invoke(CatalogAttributeInterface $attribute)
    {
        $this->persist($attribute);
    }
}
