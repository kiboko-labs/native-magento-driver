<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister\StandardDML\Attribute;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\Model\AttributeOptionInterface;
use Kiboko\Component\MagentoORM\Persister\AttributeOptionPersisterInterface;
use Kiboko\Component\MagentoORM\Persister\StandardDML\InsertUpdateAwareTrait;

class AttributeOptionPersister implements AttributeOptionPersisterInterface
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
     * @param AttributeOptionInterface $attributeOption
     */
    public function persist(AttributeOptionInterface $attributeOption)
    {
        $this->dataQueue->push($attributeOption);
    }

    /**
     * @return \Traversable
     */
    public function flush()
    {
        foreach ($this->dataQueue as $attributeOption) {
            $this->insertOnDuplicateUpdate($this->connection, $this->tableName,
                [
                    'option_id' => $attributeOption->getId(),
                    'attribute_id' => $attributeOption->getAttributeId(),
                    'sort_order' => $attributeOption->getSortOrder(),
                ],
                [
                    'attribute_id',
                    'sort_order',
                ],
                'option_id'
            );

            if ($attributeOption->getId() === null) {
                $attributeOption->persistedToId($this->connection->lastInsertId());
                yield $attributeOption;
            }
        }
    }

    /**
     * @param AttributeOptionInterface $attributeOption
     */
    public function __invoke(AttributeOptionInterface $attributeOption)
    {
        $this->persist($attributeOption);
    }
}
