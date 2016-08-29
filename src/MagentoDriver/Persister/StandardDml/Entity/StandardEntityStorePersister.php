<?php

namespace Kiboko\Component\MagentoDriver\Persister\StandardDml\Entity;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Model\EntityStoreInterface;
use Kiboko\Component\MagentoDriver\Persister\EntityStorePersisterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\InsertUpdateAwareTrait;

class StandardEntityStorePersister implements EntityStorePersisterInterface
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
     * @param EntityStoreInterface $entityStore
     */
    public function persist(EntityStoreInterface $entityStore)
    {
        $this->dataQueue->push($entityStore);
    }

    /**
     * @return \Traversable
     */
    public function flush()
    {
        foreach ($this->dataQueue as $entityStore) {
            $this->insertOnDuplicateUpdate($this->connection, $this->tableName,
                [
                    'entity_type_id' => $entityStore->getTypeId(),
                    'store_id' => $entityStore->getStoreId(),
                    'increment_prefix' => $entityStore->getIncrementPrefix(),
                    'increment_last_id' => $entityStore->getIncrementLastId(),
                ],
                [
                    'store_id',
                    'increment_prefix',
                    'increment_last_id',
                ],
                'entity_type_id'
            );

            if ($entityStore->getId() === null) {
                $entityStore->persistedToId($this->connection->lastInsertId());
                yield $entityStore;
            }
        }
    }

    /**
     * @param EntityStoreInterface $entityStore
     */
    public function __invoke(EntityStoreInterface $entityStore)
    {
        $this->persist($entityStore);
    }
}
