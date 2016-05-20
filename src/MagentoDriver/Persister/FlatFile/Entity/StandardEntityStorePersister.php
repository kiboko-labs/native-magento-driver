<?php

namespace Luni\Component\MagentoDriver\Persister\Direct\EntityStore;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Model\EntityStoreInterface;
use Luni\Component\MagentoDriver\Persister\EntityStorePersisterInterface;

class StandardEntityStorePersister implements EntityStorePersisterInterface
{
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

    public function flush()
    {
        foreach ($this->dataQueue as $entityStore) {
            $count = 0;
            if ($entityStore->getId()) {
                $count = $this->connection->update($this->tableName,
                    [
                        'entity_type_id' => $entityStore->getTypeId(),
                        'store_id' => $entityStore->getStoreId(),
                        'increment_prefix' => $entityStore->getIncrementPrefix(),
                        'increment_last_id' => $entityStore->getIncrementLastId(),
                    ],
                    [
                        'entity_store_id' => $entityStore->getId(),
                    ]
                );
            }

            if ($count <= 0) {
                $this->connection->insert($this->tableName,
                    [
                        'entity_type_id' => $entityStore->getTypeId(),
                        'store_id' => $entityStore->getStoreId(),
                        'increment_prefix' => $entityStore->getIncrementPrefix(),
                        'increment_last_id' => $entityStore->getIncrementLastId(),
                    ],
                    [
                        'entity_store_id' => $entityStore->getId(),
                    ]
                );

                $entityStore->persistToId($this->connection->lastInsertId());
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
