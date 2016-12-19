<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Persister\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\AkeneoToMagentoMapper\Persister\AttributeOptionValuePersisterInterface;

class AttributeOptionValuePersister implements AttributeOptionValuePersisterInterface
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
     * @var string
     */
    private $instanceIdentifier;

    /**
     * @var array
     */
    private $unitOfWork;

    /**
     * AttributeGroupPersister constructor.
     *
     * @param Connection $connection
     * @param string     $tableName
     * @param string     $instanceIdentifier
     */
    public function __construct(
        Connection $connection,
        $tableName,
        $instanceIdentifier = null
    ) {
        $this->connection = $connection;
        $this->tableName = $tableName;
        $this->instanceIdentifier = $instanceIdentifier;
        $this->unitOfWork = [];
    }

    /**
     * @param string     $optionsCode
     * @param string     $locale
     * @param int        $identifier
     * @param string     $mappingClass
     * @param array|null $mappingOptions
     */
    public function persist($optionsCode, $locale, $identifier, $mappingClass = null, array $mappingOptions = null)
    {
        $this->unitOfWork[] = $this->buildRow(
            [
                'value_id' => $identifier,
                'option_code' => $optionsCode,
                'locale' => $locale,
            ],
            $mappingClass,
            $mappingOptions
        );
    }

    /**
     * @param array      $data
     * @param string     $mappingClass
     * @param array|null $mappingOptions
     *
     * @return array
     */
    private function buildRow(array $data, $mappingClass = null, array $mappingOptions = null)
    {
        if ($this->instanceIdentifier !== null) {
            $data['instance_identifier'] = $this->instanceIdentifier;
        }
        if ($mappingClass !== null) {
            $data['mapping_class'] = $mappingClass;
        }
        if ($mappingOptions !== null) {
            $data['mapping_class'] = json_encode($mappingOptions, JSON_OBJECT_AS_ARRAY);
        }

        return $data;
    }

    public function flush()
    {
        foreach ($this->unitOfWork as $item) {
            $this->connection->insert($this->tableName, $item);
        }
    }
}
