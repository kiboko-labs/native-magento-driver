<?php

namespace Luni\Component\MagentoDriver\Persister\Attribute;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Luni\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;

class ExtendedAttributePersister
    implements AttributePersisterInterface
{
    /**
     * @var TemporaryWriterInterface
     */
    private $extendedTableTemporaryWriter;

    /**
     * @var DatabaseWriterInterface
     */
    private $baseTableDatabaseWriter;

    /**
     * @var DatabaseWriterInterface
     */
    private $extendedTableDatabaseWriter;

    /**
     * @var array
     */
    private $baseTableName = [];

    /**
     * @var array
     */
    private $extendedTableName = [];

    /**
     * @var string
     */
    private $baseTableKeys;

    /**
     * @var string
     */
    private $extendedTableKeys;

    /**
     * @param TemporaryWriterInterface $baseTableTemporaryWriter
     * @param TemporaryWriterInterface $extendedTableTemporaryWriter
     * @param DatabaseWriterInterface $baseTableDatabaseWriter
     * @param DatabaseWriterInterface $extendedTableDatabaseWriter
     * @param string $baseTableName
     * @param string $extendedTableName
     * @param array $baseTableKeys
     * @param array $extendedTableKeys
     */
    public function __construct(
        TemporaryWriterInterface $baseTableTemporaryWriter,
        TemporaryWriterInterface $extendedTableTemporaryWriter,
        DatabaseWriterInterface $baseTableDatabaseWriter,
        DatabaseWriterInterface $extendedTableDatabaseWriter,
        $baseTableName,
        $extendedTableName,
        array $baseTableKeys = [],
        array $extendedTableKeys = []
    ) {
        $this->baseTableTemporaryWriter = $baseTableTemporaryWriter;
        $this->extendedTableTemporaryWriter = $extendedTableTemporaryWriter;
        $this->baseTableDatabaseWriter = $baseTableDatabaseWriter;
        $this->extendedTableDatabaseWriter = $extendedTableDatabaseWriter;
        $this->baseTableName = $baseTableName;
        $this->extendedTableName = $extendedTableName;
        $this->baseTableKeys = $baseTableKeys;
        $this->extendedTableKeys = $extendedTableKeys;
    }

    /**
     * @return string
     */
    protected function getBaseTableName()
    {
        return $this->baseTableName;
    }

    /**
     * @return string
     */
    protected function getExtendedTableName()
    {
        return $this->extendedTableName;
    }

    /**
     * @return array
     */
    protected function getBaseTableKeys()
    {
        return $this->baseTableKeys;
    }

    /**
     * @return array
     */
    protected function getExtendedTableKeys()
    {
        return $this->extendedTableKeys;
    }

    public function initialize()
    {
    }

    public function persist(AttributeInterface $attribute)
    {
        $this->baseTableTemporaryWriter->persistRow([]);

        $this->extendedTableTemporaryWriter->persistRow([]);
    }

    public function flush()
    {
        $this->baseTableTemporaryWriter->flush();
        $this->extendedTableTemporaryWriter->flush();

        $this->baseTableDatabaseWriter->write($this->getBaseTableName(), $this->getBaseTableKeys());
        $this->extendedTableDatabaseWriter->write($this->getExtendedTableName(), $this->getExtendedTableKeys());
    }

    public function __invoke(AttributeInterface $attribute)
    {
        $this->persist($attribute);
    }
}