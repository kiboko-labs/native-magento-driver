<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister\FlatFile\Attribute;

use Kiboko\Component\MagentoORM\Model\AttributeGroupInterface;
use Kiboko\Component\MagentoORM\Persister\FlatFile\BaseFlatFilePersisterTrait;
use Kiboko\Component\MagentoORM\Persister\AttributeGroupPersisterInterface;
use Kiboko\Component\MagentoORM\Writer\Database\DatabaseWriterInterface;
use Kiboko\Component\MagentoORM\Writer\Temporary\TemporaryWriterInterface;

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
