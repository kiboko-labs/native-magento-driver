<?php

namespace Luni\Component\MagentoDriver\Persister\FlatFile\Attribute;

use Luni\Component\MagentoDriver\Model\AttributeOptionValueInterface;
use Luni\Component\MagentoDriver\Persister\FlatFile\BaseFlatFilePersisterTrait;
use Luni\Component\MagentoDriver\Persister\AttributeOptionValuePersisterInterface;
use Luni\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Luni\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;

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
