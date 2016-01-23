<?php

namespace Luni\Component\MagentoDriver\Persister\Attribute;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Persister\BaseCsvPersisterTrait;

class StandardAttributePersister
    implements AttributePersisterInterface
{
    use BaseCsvPersisterTrait;

    public function initialize()
    {
    }

    public function persist(AttributeInterface $attribute)
    {
        $this->temporaryWriter->persistRow([]);
    }

    public function __invoke(AttributeInterface $attribute)
    {
        $this->persist($attribute);
    }

    public function flush()
    {
        $this->doFlush();
    }
}