<?php

namespace Luni\Component\MagentoDriver\Persister\FlatFile\Attribute;

use Luni\Component\MagentoDriver\Model\AttributeGroupInterface;
use Luni\Component\MagentoDriver\Persister\FlatFile\BaseFlatFilePersisterTrait;
use Luni\Component\MagentoDriver\Persister\AttributeGroupPersisterInterface;
use Luni\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Luni\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;

class AttributeGroupPersister implements AttributeGroupPersisterInterface
{
    use BaseFlatFilePersisterTrait;

    /**
     * @param TemporaryWriterInterface $temporaryWriter
     * @param DatabaseWriterInterface  $databaseWriter
     * @param string                   $tableName
     * @param array                    $tableKeys
     */
    public function __construct(
        TemporaryWriterInterface $temporaryWriter,
        DatabaseWriterInterface $databaseWriter,
        $tableName,
        array $tableKeys = []
    ) {
        $this->temporaryWriter = $temporaryWriter;
        $this->databaseWriter = $databaseWriter;
        $this->tableName = $tableName;
        $this->tableKeys = $tableKeys;
    }

    public function initialize()
    {
    }

    /**
     * @param AttributeGroupInterface $attributeGroupInterface
     */
    public function persist(AttributeGroupInterface $attributeGroupInterface)
    {
        $this->temporaryWriter->persistRow([
            'attribute_group_id' => $attributeGroupInterface->getId(),
            'attribute_set_id' => $attributeGroupInterface->getFamilyId(),
            'attribute_group_name' => $attributeGroupInterface->getLabel(),
            'sort_order' => $attributeGroupInterface->getSortOrder(),
            'default_d' => $attributeGroupInterface->getDefaultId(),
        ]);
    }

    /**
     * @param AttributeGroupInterface $attributeGroup
     */
    public function __invoke(AttributeGroupInterface $attributeGroup)
    {
        $this->persist($attributeGroup);
    }

    public function flush()
    {
        $this->doFlush();
    }

    /**
     * @return \Generator
     */
    protected function walkQueue()
    {
    }
}
