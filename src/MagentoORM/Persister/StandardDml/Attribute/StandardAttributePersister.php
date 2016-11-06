<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister\StandardDml\Attribute;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Persister\AttributePersisterInterface;
use Kiboko\Component\MagentoORM\Persister\StandardDml\InsertUpdateAwareTrait;

class StandardAttributePersister implements AttributePersisterInterface
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
     * @param AttributeInterface $attribute
     */
    public function persist(AttributeInterface $attribute)
    {
        $this->dataQueue->push($attribute);
    }

    /**
     * @return \Traversable
     */
    public function flush()
    {
        /** @var AttributeInterface $attribute */
        foreach ($this->dataQueue as $attribute) {
            $this->insertOnDuplicateUpdate($this->connection, $this->tableName,
                [
                    'attribute_id' => $attribute->getId(),
                    'entity_type_id' => $attribute->getEntityTypeId(),
                    'attribute_code' => $attribute->getCode(),
                    'attribute_model' => $attribute->getModelClass(),
                    'backend_type' => $attribute->getBackendType(),
                    'backend_model' => $attribute->getBackendModelClass(),
                    'backend_table' => $attribute->getBackendTable(),
                    'frontend_model' => $attribute->getFrontendModelClass(),
                    'frontend_input' => $attribute->getFrontendInput(),
                    'frontend_label' => $attribute->getFrontendLabel(),
                    'frontend_class' => $attribute->getFrontendViewClass(),
                    'source_model' => $attribute->getSourceModelClass(),
                    'is_required' => (int) $attribute->isRequired(),
                    'is_user_defined' => $attribute->isUserDefined(),
                    'is_unique' => (int) $attribute->isUnique(),
                    'default_value' => $attribute->getDefaultValue(),
                    'note' => $attribute->getNote(),
                ],
                [
                    'entity_type_id',
                    'attribute_code',
                    'attribute_model',
                    'backend_type',
                    'backend_model',
                    'backend_table',
                    'frontend_model',
                    'frontend_input',
                    'frontend_label',
                    'frontend_class',
                    'source_model',
                    'is_required',
                    'is_user_defined',
                    'is_unique',
                    'default_value',
                    'note',
                ],
                'attribute_id'
            );

            if ($attribute->getId() === null) {
                $attribute->persistedToId($this->connection->lastInsertId());
                yield $attribute;
            }
        }
    }

    /**
     * @param AttributeInterface $attribute
     */
    public function __invoke(AttributeInterface $attribute)
    {
        $this->persist($attribute);
    }
}
