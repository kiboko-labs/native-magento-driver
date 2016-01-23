<?php

namespace Luni\Component\MagentoDriver\Persister\Family;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\FamilyInterface;
use Luni\Component\MagentoDriver\Persister\BaseCsvPersisterTrait;
use Luni\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Luni\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;

class StandardFamilyPersister
    implements FamilyPersisterInterface
{
    use BaseCsvPersisterTrait;

    public function initialize()
    {
    }

    public function persist(FamilyInterface $familyInterface)
    {
        $this->temporaryWriter->persistRow([
            'attribute_set_id'   => $familyInterface->getId(),
            'entity_type_id'     => 4,
            'attribute_set_name' => $familyInterface->getLabel(),
            'sort_order'         => 0,
        ]);
    }

    public function __invoke(FamilyInterface $family)
    {
        $this->persist($family);
    }

    public function flush()
    {
        $this->doFlush();
    }
}