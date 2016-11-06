<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Persister\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\AkeneoToMagentoMapper\Persister\AttributeGroupPersisterInterface;

class AttributeGroupPersister implements AttributeGroupPersisterInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var string
     */
    private $tableName;

    /**
     * @var array
     */
    private $unitOfWork;

    /**
     * AttributeGroupPersister constructor.
     *
     * @param Connection $connection
     * @param string     $tableName
     */
    public function __construct(
        Connection $connection,
        $tableName
    ) {
        $this->connection = $connection;
        $this->tableName = $tableName;
        $this->unitOfWork = [];
    }

    /**
     * @param string $groupCode
     * @param string $familyCode
     * @param int    $identifier
     */
    public function persist($groupCode, $familyCode, $identifier)
    {
        $this->unitOfWork[] = [
            'attribute_group_id' => $identifier,
            'attribute_group_code' => $groupCode,
            'family_code' => $familyCode,
        ];
    }

    public function flush()
    {
        foreach ($this->unitOfWork as $item) {
            $this->connection->insert($this->tableName, $item);
        }
    }
}
