<?php

namespace Kiboko\Component\MagentoMapper\Persister\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoMapper\Persister\AttributePersisterInterface;

class AttributeOptionPersister implements AttributePersisterInterface
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
     * @param int $code
     * @param string $identifier
     */
    public function persist($code, $identifier)
    {
        $this->connection->insert($this->tableName,
            [
                'option_id' => $identifier,
                'option_code' => $code,
            ]
        );
    }
}
