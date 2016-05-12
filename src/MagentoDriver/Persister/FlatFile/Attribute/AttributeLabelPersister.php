<?php

namespace Luni\Component\MagentoDriver\Persister\FlatFile\Attribute;

use Luni\Component\MagentoDriver\Model\AttributeLabelInterface;
use Luni\Component\MagentoDriver\Persister\FlatFile\BaseFlatFilePersisterTrait;
use Luni\Component\MagentoDriver\Persister\AttributeLabelPersisterInterface;
use Luni\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Luni\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;

class AttributeLabelPersister implements AttributeLabelPersisterInterface
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
     * @param AttributeLabelInterface $attributeLabelInterface
     */
    public function persist(AttributeLabelInterface $attributeLabelInterface)
    {
        $this->temporaryWriter->persistRow([
            'attribute_label_id' => $attributeLabelInterface->getId(),
            'attribute_id' => $attributeLabelInterface->getAttributeId(),
            'store_id' => $attributeLabelInterface->getStoreId(),
            'value' => $attributeLabelInterface->getValue()
        ]);
    }

    /**
     * @param AttributeLabelInterface $attributeLabel
     */
    public function __invoke(AttributeLabelInterface $attributeLabel)
    {
        $this->persist($attributeLabel);
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
