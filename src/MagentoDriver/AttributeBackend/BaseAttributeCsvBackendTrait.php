<?php

namespace Luni\Component\MagentoDriver\AttributeBackend;

use League\Flysystem\File;
use Luni\Component\MagentoDriver\AttributeValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\Entity\ProductInterface;
use Luni\Component\MagentoDriver\Exception\RuntimeErrorException;
use Luni\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Luni\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;

trait BaseAttributeCsvBackendTrait
{
    /**
     * @var TemporaryWriterInterface
     */
    private $temporaryWriter;

    /**
     * @var DatabaseWriterInterface
     */
    private $databaseWriter;

    /**
     * @var array
     */
    private $tableKeys = [
        'value_id',
        'entity_type_id',
        'attribute_id',
        'store_id',
        'entity_id',
        'value',
    ];

    /**
     * @var string
     */
    private $tableName;

    /**
     * @param TemporaryWriterInterface $temporaryWriter
     * @param DatabaseWriterInterface $databaseWriter
     * @param string $tableName
     */
    public function __construct(
        TemporaryWriterInterface $temporaryWriter,
        DatabaseWriterInterface $databaseWriter,
        $tableName
    ) {
        $this->temporaryWriter = $temporaryWriter;
        $this->databaseWriter = $databaseWriter;
        $this->tableName = $tableName;
    }

    /**
     * @throws RuntimeErrorException
     */
    public function initialize()
    {
    }

    /**
     * @param ProductInterface $product
     * @param AttributeValueInterface $value
     */
    abstract public function persist(ProductInterface $product, AttributeValueInterface $value);

    /**
     * Flushes data into the DB
     */
    public function flush()
    {
        $this->temporaryWriter->flush();

        $this->databaseWriter->write($this->tableName, $this->tableKeys);
    }
}