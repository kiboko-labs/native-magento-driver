<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Model\AttributeGroupInterface;
use Kiboko\Component\MagentoDriver\Persister\AttributeGroupPersisterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\InsertUpdateAwareTrait;

trait AttributeGroupPersisterTrait
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
     * @param AttributeGroupInterface $attributeGroup
     */
    public function persist(AttributeGroupInterface $attributeGroup)
    {
        $this->dataQueue->push($attributeGroup);
    }

    abstract protected function getInsertData(AttributeGroupInterface $attributeGroup);
    abstract protected function getUpdatedFields();
    abstract protected function getIdentifierField();

    /**
     * @return \Traversable
     */
    public function flush()
    {
        foreach ($this->dataQueue as $attributeGroup) {
            $this->insertOnDuplicateUpdate(
                $this->connection,
                $this->tableName,
                $this->getInsertData($attributeGroup),
                $this->getUpdatedFields(),
                $this->getIdentifierField()
            );

            if ($attributeGroup->getId() === null) {
                $attributeGroup->persistedToId($this->connection->lastInsertId());
                yield $attributeGroup;
            }
        }
    }

    /**
     * @param AttributeGroupInterface $attributeGroup
     */
    public function __invoke(AttributeGroupInterface $attributeGroup)
    {
        $this->persist($attributeGroup);
    }
}
