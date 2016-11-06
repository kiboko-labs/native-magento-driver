<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister\StandardDml\Attribute;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\Exception\RuntimeErrorException;
use Kiboko\Component\MagentoORM\Model\CatalogAttributeExtensionInterface;
use Kiboko\Component\MagentoORM\Persister\StandardDml\InsertUpdateAwareTrait;

trait CatalogAttributeExtensionPersisterTrait
{
    use InsertUpdateAwareTrait;

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var string
     */
    private $tableName;

    /**
     * @var \SplQueue
     */
    private $dataQueue;

    /**
     * @param Connection $connection
     * @param string     $tableName
     */
    public function __construct(
        Connection $connection,
        $tableName
    ) {
        $this->connection = $connection;
        $this->tableName = $tableName;
        $this->dataQueue = new \SplQueue();
    }

    /**
     * @return string
     */
    protected function getTableName()
    {
        return $this->tableName;
    }

    public function initialize()
    {
        $this->dataQueue = new \SplQueue();
    }

    /**
     * @param CatalogAttributeExtensionInterface $attribute
     */
    public function persist(CatalogAttributeExtensionInterface $attribute)
    {
        $this->dataQueue->push($attribute);
    }

    /**
     * @param CatalogAttributeExtensionInterface $attributeExtension
     * @return array
     */
    abstract protected function getInsertData(CatalogAttributeExtensionInterface $attributeExtension);

    /**
     * @return array
     */
    abstract protected function getUpdatedFields();

    /**
     * @return string
     */
    abstract protected function getIdentifierField();

    /**
     * @return \Traversable
     */
    public function flush()
    {
        /** @var CatalogAttributeExtensionInterface $attribute */
        foreach ($this->dataQueue as $attribute) {
            if (!$attribute->getId()) {
                throw new RuntimeErrorException('Attribute id should be defined.');
            }

            $this->insertOnDuplicateUpdate(
                $this->connection,
                $this->tableName,
                $this->getInsertData($attribute),
                $this->getUpdatedFields(),
                $this->getIdentifierField()
            );

            yield $attribute;
        }
    }

    /**
     * @param CatalogAttributeExtensionInterface $attribute
     */
    public function __invoke(CatalogAttributeExtensionInterface $attribute)
    {
        $this->persist($attribute);
    }
}
