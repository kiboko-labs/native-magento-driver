<?php

namespace Luni\Component\MagentoDriver\Persister\FlatFile\AttributeValue;

use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Model\DecimalAttributeValueInterface;
use Luni\Component\MagentoDriver\Persister\AttributeValuePersisterInterface;
use Luni\Component\MagentoDriver\Persister\FlatFile\BaseFlatFilePersisterTrait;
use Luni\Component\MagentoDriver\Exception\InvalidAttributePersisterTypeException;
use Luni\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Luni\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;

class DecimalAttributeValuePersister implements AttributeValuePersisterInterface
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
     * @param AttributeValueInterface $value
     */
    public function persist(AttributeValueInterface $value)
    {
        if (!$value instanceof DecimalAttributeValueInterface) {
            throw new InvalidAttributePersisterTypeException(sprintf(
                'Invalid attribute value type for "%s", expected "%s", got "%s".',
                $value->getAttributeCode(),
                DecimalAttributeValueInterface::class,
                get_class($value)
            ));
        }

        $this->temporaryWriter->persistRow([
            'value_id' => $value->getId(),
            'entity_type_id' => 4,
            'attribute_id' => $value->getAttributeId(),
            'store_id' => $value->getStoreId(),
            'entity_id' => $value->getProductId(),
            'value' => number_format($value->getValue(), 4),
        ]);
    }

    /**
     * @param AttributeValueInterface $value
     */
    public function __invoke(AttributeValueInterface $value)
    {
        $this->persist($value);
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
