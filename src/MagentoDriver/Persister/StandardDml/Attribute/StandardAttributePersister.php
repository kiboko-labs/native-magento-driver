<?php

namespace Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Persister\AttributePersisterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\InsertUpdateAwareTrait;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilder;

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

    public function flush()
    {
        /** @var AttributeInterface $attribute */
        foreach ($this->dataQueue as $attribute) {
            $this->insertOnDuplicateUpdate(
                    $this->connection, 
                    $this->tableName, 
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
                    ProductAttributeQueryBuilder::getDefaultFields()
            );

            $attribute->persistedToId($this->connection->lastInsertId());
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
