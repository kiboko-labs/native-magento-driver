<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister;

use Kiboko\Component\MagentoORM\Model\CatalogAttributeInterface;

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
        $this->standardAttributePersister->flush();
        $this->catalogAttributeExtensionPersister->flush();
    }

    /**
     * @param CatalogAttributeInterface $attribute
     */
    public function __invoke(CatalogAttributeInterface $attribute)
    {
        $this->persist($attribute);
    }
}
