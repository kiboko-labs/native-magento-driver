<?php

namespace Luni\Component\MagentoDriver\Persister\Direct\Family;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Model\FamilyInterface;
use Luni\Component\MagentoDriver\Persister\FamilyPersisterInterface;

class StandardFamilyPersister implements FamilyPersisterInterface
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
     * @param FamilyInterface $family
     */
    public function persist(FamilyInterface $family)
    {
        $this->dataQueue->push($family);
    }

    public function flush()
    {
        foreach ($this->dataQueue as $family) {
            if ($family->getId()) {
                $this->connection->update($this->tableName,
                    [
                        'entity_type_id' => 4,
                        'attribute_set_name' => $family->getLabel(),
                        'sort_order' => 0,
                    ],
                    [
                        'attribute_set_id' => $family->getId(),
                    ]
                );
            } else {
                $this->connection->insert($this->tableName,
                    [
                        'entity_type_id' => 4,
                        'attribute_set_name' => $family->getLabel(),
                        'sort_order' => 0,
                    ]
                );

                $family->persistedToId($this->connection->lastInsertId());
            }
        }
    }

    /**
     * @param FamilyInterface $family
     */
    public function __invoke(FamilyInterface $family)
    {
        $this->persist($family);
    }
}
