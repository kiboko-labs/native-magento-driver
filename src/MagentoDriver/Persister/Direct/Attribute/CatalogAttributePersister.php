<?php

namespace Luni\Component\MagentoDriver\Persister\Direct\Attribute;

use Luni\Component\MagentoDriver\Model\CatalogAttributeInterface;
use Luni\Component\MagentoDriver\Persister\AttributePersisterInterface;
use Luni\Component\MagentoDriver\Persister\CatalogAttributeExtensionPersisterInterface;
use Luni\Component\MagentoDriver\Persister\CatalogAttributePersisterInterface;

class CatalogAttributePersister
    implements CatalogAttributePersisterInterface
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
     * @param AttributePersisterInterface $standardAttributePersister
     * @param CatalogAttributeExtensionPersisterInterface $catalogAttributeExtensionPersister
     */
    public function __construct(
        AttributePersisterInterface $standardAttributePersister,
        CatalogAttributeExtensionPersisterInterface $catalogAttributeExtensionPersister
    ) {
        $this->standardAttributePersister = $standardAttributePersister;
        $this->catalogAttributeExtensionPersister = $catalogAttributeExtensionPersister;
    }

    /**
     * @return void
     */
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
     * @return void
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
