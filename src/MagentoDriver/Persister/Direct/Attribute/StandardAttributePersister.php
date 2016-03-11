<?php

namespace Luni\Component\MagentoDriver\Persister\Direct\Attribute;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Persister\AttributePersisterInterface;

class StandardAttributePersister
    implements AttributePersisterInterface
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
     * @var \SplQueue
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
     * @return void
     */
    public function flush()
    {
        /** @var AttributeInterface $attribute */
        foreach ($this->dataQueue as $attribute) {
            if ($attribute->getId()) {
                $this->connection->update($this->tableName,
                    [
                        'attribute_id'    => $attribute->getId(),
                        'entity_type_id'  => $attribute->getEntityTypeId(),
                        'attribute_code'  => $attribute->getCode(),
                        'attribute_model' => $attribute->getModelClass(),
                        'backend_model'   => $attribute->getBackendModelClass(),
                        'backend_type'    => $attribute->getBackendType(),
                        'backend_table'   => $attribute->getBackendTable(),
                        'frontend_model'  => $attribute->getFrontendModelClass(),
                        'frontend_input'  => $attribute->getFrontendType(),
                        'frontend_label'  => $attribute->getFrontendLabel(),
                        'frontend_class'  => $attribute->getFrontendModelClass(),
                        'source_model'    => $attribute->getSourceModelClass(),
                        'is_required'     => $attribute->isRequired(),
                        'is_user_defined' => $attribute->isUserDefined(),
                        'default_value'   => $attribute->getDefaultValue(),
                        'is_unique'       => $attribute->isUnique(),
                        'note'            => $attribute->getNote(),
                    ],
                    [
                        'attribute_id' => $attribute->getId(),
                    ]
                );
            } else {
                $this->connection->insert($this->tableName,
                    [
                        'entity_type_id'  => $attribute->getEntityTypeId(),
                        'attribute_code'  => $attribute->getCode(),
                        'attribute_model' => $attribute->getModelClass(),
                        'backend_model'   => $attribute->getBackendModelClass(),
                        'backend_type'    => $attribute->getBackendType(),
                        'backend_table'   => $attribute->getBackendTable(),
                        'frontend_model'  => $attribute->getFrontendModelClass(),
                        'frontend_input'  => $attribute->getFrontendType(),
                        'frontend_label'  => $attribute->getFrontendLabel(),
                        'frontend_class'  => $attribute->getFrontendModelClass(),
                        'source_model'    => $attribute->getSourceModelClass(),
                        'is_required'     => $attribute->isRequired(),
                        'is_user_defined' => $attribute->isUserDefined(),
                        'default_value'   => $attribute->getDefaultValue(),
                        'is_unique'       => $attribute->isUnique(),
                        'note'            => $attribute->getNote(),
                    ]
                );

                $attribute->persistedToId($this->connection->lastInsertId());
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
