<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister\FlatFile\Attribute;

use Kiboko\Component\MagentoORM\Model\CatalogAttributeExtensionInterface;
use Kiboko\Component\MagentoORM\Writer\Database\DatabaseWriterInterface;
use Kiboko\Component\MagentoORM\Writer\Temporary\TemporaryWriterInterface;

trait CatalogAttributeExtensionPersisterTrait
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
     * @var string
     */
    private $tableName;

    /**
     * @var array
     */
    private $tableKeys;

    /**
     * @param TemporaryWriterInterface    $temporaryWriter
     * @param DatabaseWriterInterface     $databaseWriter
     * @param string                      $tableName
     * @param array                       $tableKeys
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
     * @param CatalogAttributeExtensionInterface $attribute
     */
    abstract public function persist(CatalogAttributeExtensionInterface $attribute);

    /**
     * @return \Traversable
     */
    public function flush()
    {
        $this->temporaryWriter->flush();
        $this->databaseWriter->write(
            $this->getTableName(),
            $this->getTableKeys()
        );
    }

    /**
     * @return string
     */
    protected function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @return array
     */
    protected function getTableKeys()
    {
        return $this->tableKeys;
    }

    /**
     * @param CatalogAttributeExtensionInterface $attribute
     */
    public function __invoke(CatalogAttributeExtensionInterface $attribute)
    {
        $this->persist($attribute);
    }
}
