<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Persister\StandardDml\SuperLink;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Model\SuperLinkInterface;
use Kiboko\Component\MagentoDriver\Persister\SuperLinkPersisterInterface;

class ProductSuperLinkPersister implements SuperLinkPersisterInterface
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
     * @param SuperLinkInterface $superLink
     */
    public function persist(SuperLinkInterface $superLink)
    {
        $this->dataQueue->push($superLink);
    }

    public function flush()
    {
        foreach ($this->dataQueue as $superLink) {
            $count = 0;
            if ($superLink->getId()) {
                $count = $this->connection->update($this->tableName,
                    [
                        'parent_id' => $superLink->getConfigurableId(),
                        'product_id' => $superLink->getVariantId(),
                    ],
                    [
                        'link_id' => $superLink->getId(),
                    ]
                );
            }

            if ($count <= 0) {
                $this->connection->insert($this->tableName,
                    [
                        'link_id' => $superLink->getId(),
                        'parent_id' => $superLink->getConfigurableId(),
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
