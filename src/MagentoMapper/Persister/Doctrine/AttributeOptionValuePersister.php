<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

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

    private $unitOfWork;

    public function __construct(
        Connection $connection,
        $tableName
    ) {
        $this->connection = $connection;
        $this->tableName = $tableName;
        $this->unitOfWork = [];
    }

    /**
     * @param string $optionsCode
     * @param string $locale
     * @param int    $identifier
     */
    public function persist($optionsCode, $locale, $identifier)
    {
        $this->unitOfWork[] = [
            'value_id' => $identifier,
            'option_code' => $optionsCode,
            'locale' => $locale,
        ];
    }

    public function flush()
    {
        foreach ($this->unitOfWork as $item) {
            $this->connection->insert($this->tableName, $item);
        }
    }
}
