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
        foreach ($this->dataQueue as $attribute) {
            if ($attribute->getId()) {
                $this->connection->update($this->tableName,
                    [
                        'attribute_id'    => $attribute->getId(),
                        'entity_type_id'  => $attribute->getOptionOrDefault('entity_type_id'),
                        'attribute_code'  => $attribute->getCode(),
                        'attribute_model' => $attribute->getOptionOrDefault('attribute_model'),
                        'backend_model'   => $attribute->getOptionOrDefault('backend_model'),
                        'backend_type'    => $attribute->getBackendType(),
                        'backend_table'   => $attribute->getOptionOrDefault('backend_table'),
                        'frontend_model'  => $attribute->getOptionOrDefault('frontend_model'),
                        'frontend_input'  => $attribute->getFrontendType(),
                        'frontend_label'  => $attribute->getOptionOrDefault('frontend_label'),
                        'frontend_class'  => $attribute->getOptionOrDefault('frontend_class'),
                        'source_model'    => $attribute->getOptionOrDefault('source_model'),
                        'is_required'     => $attribute->getOptionOrDefault('is_required'),
                        'is_user_defined' => $attribute->getOptionOrDefault('is_user_defined'),
                        'default_value'   => $attribute->getOptionOrDefault('default_value'),
                        'is_unique'       => $attribute->getOptionOrDefault('is_unique'),
                        'note'            => $attribute->getOptionOrDefault('note'),
                    ],
                    [
                        'attribute_id' => $attribute->getId(),
                    ]
                );
            } else {
                $this->connection->insert($this->tableName,
                    [
                        'entity_type_id'  => $attribute->getOptionOrDefault('entity_type_id'),
                        'attribute_code'  => $attribute->getCode(),
                        'attribute_model' => $attribute->getOptionOrDefault('attribute_model'),
                        'backend_model'   => $attribute->getOptionOrDefault('backend_model'),
                        'backend_type'    => $attribute->getBackendType(),
                        'backend_table'   => $attribute->getOptionOrDefault('backend_table'),
                        'frontend_model'  => $attribute->getOptionOrDefault('frontend_model'),
                        'frontend_input'  => $attribute->getFrontendType(),
                        'frontend_label'  => $attribute->getOptionOrDefault('frontend_label'),
                        'frontend_class'  => $attribute->getOptionOrDefault('frontend_class'),
                        'source_model'    => $attribute->getOptionOrDefault('source_model'),
                        'is_required'     => $attribute->getOptionOrDefault('is_required'),
                        'is_user_defined' => $attribute->getOptionOrDefault('is_user_defined'),
                        'default_value'   => $attribute->getOptionOrDefault('default_value'),
                        'is_unique'       => $attribute->getOptionOrDefault('is_unique'),
                        'note'            => $attribute->getOptionOrDefault('note'),
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
