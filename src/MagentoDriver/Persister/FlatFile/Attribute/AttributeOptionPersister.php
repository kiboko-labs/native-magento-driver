<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Persister\FlatFile\Attribute;

use Kiboko\Component\MagentoDriver\Model\AttributeOptionInterface;
use Kiboko\Component\MagentoDriver\Persister\FlatFile\BaseFlatFilePersisterTrait;
use Kiboko\Component\MagentoDriver\Persister\AttributeOptionPersisterInterface;
use Kiboko\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Kiboko\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;

class AttributeOptionPersister implements AttributeOptionPersisterInterface
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
     * @param AttributeOptionInterface $attributeOptionInterface
     */
    public function persist(AttributeOptionInterface $attributeOptionInterface)
    {
        $this->temporaryWriter->persistRow([
            'option_id' => $attributeOptionInterface->getId(),
            'attribute_id' => $attributeOptionInterface->getAttributeId(),
            'sort_order' => $attributeOptionInterface->getSortOrder(),
        ]);
    }

    /**
     * @param AttributeOptionInterface $attributeOption
     */
    public function __invoke(AttributeOptionInterface $attributeOption)
    {
        $this->persist($attributeOption);
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
