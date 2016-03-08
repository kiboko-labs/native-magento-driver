<?php

namespace Luni\Component\MagentoDriver\Persister\Direct\SuperLink;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Model\SuperLinkInterface;
use Luni\Component\MagentoDriver\Persister\SuperLinkPersisterInterface;

class ProductSuperLinkPersister
    implements SuperLinkPersisterInterface
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
     * @var \SplQueue|SuperLinkInterface[]
     */
    private $dataQueue;

    /**
     * @param Connection $connection
     * @param string $tableName
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

    /**
     * @return void
     */
    public function initialize()
    {
    }

    /**
     * @param SuperLinkInterface $superLink
     */
    public function persist(SuperLinkInterface $superLink)
    {
        $this->dataQueue->push($superLink);
    }

    /**
     * @return void
     */
    public function flush()
    {
        foreach ($this->dataQueue as $superLink) {
            if ($superLink->getId()) {
                $this->connection->update($this->tableName,
                    [
                        'parent_id'  => $superLink->getConfigurableId(),
                        'product_id' => $superLink->getVariantId(),
                    ],
                    [
                        'link_id'    => $superLink->getId(),
                    ]
                );
            } else {
                $this->connection->insert($this->tableName,
                    [
                        'parent_id'  => $superLink->getConfigurableId(),
                        'product_id' => $superLink->getVariantId(),
                    ]
                );

                $superLink->persistedToId($this->connection->lastInsertId());
            }
        }
    }

    /**
     * @param SuperLinkInterface $superLink
     */
    public function __invoke(SuperLinkInterface $superLink)
    {
        $this->persist($superLink);
    }
}