<?php

namespace Kiboko\Component\MagentoMapper\Persister\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoMapper\Persister\AttributePersisterInterface;

class AttributePersister implements AttributePersisterInterface
{
    /**
     * @var Connection
     */
    private $connection;

    private $tableName;

    public function __construct(
        Connection $connection,
        $tableName
    ) {
        $this->connection = $connection;
        $this->tableName = $tableName;
    }

    /**
     * @param string $code
     * @param int $identifier
     */
    public function persist($code, $identifier)
    {
        $this->connection->insert($this->tableName,
            [
                'attribute_id'   => $identifier,
                'attribute_code' => $code,
            ]
        );
    }
}
