<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister\FlatFile\Attribute;

use Kiboko\Component\MagentoORM\Model\AttributeLabelInterface;
use Kiboko\Component\MagentoORM\Persister\FlatFile\BaseFlatFilePersisterTrait;
use Kiboko\Component\MagentoORM\Persister\AttributeLabelPersisterInterface;
use Kiboko\Component\MagentoORM\Writer\Database\DatabaseWriterInterface;
use Kiboko\Component\MagentoORM\Writer\Temporary\TemporaryWriterInterface;

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
            'value' => $attributeLabelInterface->getValue(),
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
