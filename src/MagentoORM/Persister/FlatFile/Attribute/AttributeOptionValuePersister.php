<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister\FlatFile\Attribute;

use Kiboko\Component\MagentoORM\Model\AttributeOptionValueInterface;
use Kiboko\Component\MagentoORM\Persister\FlatFile\BaseFlatFilePersisterTrait;
use Kiboko\Component\MagentoORM\Persister\AttributeOptionValuePersisterInterface;
use Kiboko\Component\MagentoORM\Writer\Database\DatabaseWriterInterface;
use Kiboko\Component\MagentoORM\Writer\Temporary\TemporaryWriterInterface;

class AttributeOptionValuePersister implements AttributeOptionValuePersisterInterface
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
     * @param AttributeOptionValueInterface $attributeOptionValueInterface
     */
    public function persist(AttributeOptionValueInterface $attributeOptionValueInterface)
    {
        $this->temporaryWriter->persistRow([
            'value_id' => $attributeOptionValueInterface->getId(),
            'option_id' => $attributeOptionValueInterface->getOptionId(),
            'store_id' => $attributeOptionValueInterface->getStoreId(),
            'value' => $attributeOptionValueInterface->getValue(),
        ]);
    }

    /**
     * @param AttributeOptionValueInterface $attributeOptionValue
     */
    public function __invoke(AttributeOptionValueInterface $attributeOptionValue)
    {
        $this->persist($attributeOptionValue);
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
