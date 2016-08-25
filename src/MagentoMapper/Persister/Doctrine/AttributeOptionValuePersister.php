<?php

namespace Kiboko\Component\MagentoMapper\Persister\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoMapper\Persister\AttributeOptionValuePersisterInterface;

class AttributeOptionValuePersister implements AttributeOptionValuePersisterInterface
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
     * @param string $optionsCode
     * @param string $locale
     * @param int $identifier
     */
    public function persist($optionsCode, $locale, $identifier)
    {
        $this->connection->insert($this->tableName,
            [
                'value_id'    => $identifier,
                'option_code' => $optionsCode,
                'locale'      => $locale,
            ]
        );
    }
}
