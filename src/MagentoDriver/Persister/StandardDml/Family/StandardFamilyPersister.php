<?php

namespace Kiboko\Component\MagentoDriver\Persister\StandardDml\Family;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Model\FamilyInterface;
use Kiboko\Component\MagentoDriver\Persister\FamilyPersisterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\InsertUpdateAwareTrait;

class StandardFamilyPersister implements FamilyPersisterInterface
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
     * @param FamilyInterface $family
     */
    public function persist(FamilyInterface $family)
    {
        $this->dataQueue->push($family);
    }

    /**
     * @return \Traversable
     */
    public function flush()
    {
        foreach ($this->dataQueue as $family) {
            $this->insertOnDuplicateUpdate($this->connection, $this->tableName,
                [
                    'attribute_set_id' => $family->getId(),
                    'entity_type_id' => 4,
                    'attribute_set_name' => $family->getLabel(),
                    'sort_order' => $family->getSortOrder(),
                ],
                [
                    'entity_type_id',
                    'attribute_set_name',
                    'sort_order',
                ],
                'attribute_set_id'
            );

            if ($family->getId() === null) {
                $family->persistedToId($this->connection->lastInsertId());
                yield $family;
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
