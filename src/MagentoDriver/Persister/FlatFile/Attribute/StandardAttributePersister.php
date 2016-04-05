<?php

namespace Luni\Component\MagentoDriver\Persister\FlatFile\Attribute;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Persister\AttributePersisterInterface;
use Luni\Component\MagentoDriver\Persister\FlatFile\BaseFlatFilePersisterTrait;
use Luni\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Luni\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;

class StandardAttributePersister implements AttributePersisterInterface
{
    use BaseFlatFilePersisterTrait;

    /**
     * @param TemporaryWriterInterface $temporaryWriter
     * @param DatabaseWriterInterface  $databaseWriter
     * @param string                   $tableName
     * @param array                    $tableKeys
     */
    public function __construct(
        TemporaryWriterInterface $temporaryWriter,
        DatabaseWriterInterface $databaseWriter,
        $tableName,
        array $tableKeys = []
    ) {
        $this->temporaryWriter = $temporaryWriter;
        $this->databaseWriter = $databaseWriter;
        $this->tableName = $tableName;
        $this->tableKeys = $tableKeys;
    }

    public function initialize()
    {
    }

    /**
     * @param AttributeInterface $attribute
     */
    public function persist(AttributeInterface $attribute)
    {
        $this->temporaryWriter->persistRow([
            'attribute_id' => $attribute->getId(),
            'entity_type_id' => $attribute->getEntityTypeId(),
            'attribute_code' => $attribute->getCode(),
            'attribute_model' => $attribute->getModelClass(),
            'backend_type' => $attribute->getBackendType(),
            'backend_model' => $attribute->getBackendModelClass(),
            'backend_table' => $attribute->getBackendTable(),
            'frontend_model' => $attribute->getFrontendModelClass(),
            'frontend_input' => $attribute->getFrontendViewClass(),
            'frontend_label' => $attribute->getFrontendLabel(),
            'frontend_class' => $attribute->getFrontendModelClass(),
            'source_model' => $attribute->getSourceModelClass(),
            'is_required' => $attribute->isRequired(),
            'is_user_defined' => $attribute->isUserDefined(),
            'is_unique' => $attribute->isUnique(),
            'default_value' => $attribute->getDefaultValue(),
            'note' => $attribute->getNote(),
        ]);
    }

    public function __invoke(AttributeInterface $attribute)
    {
        $this->persist($attribute);
    }

    public function flush()
    {
        $this->doFlush();
    }

    /**
     * @return \Generator
     */
    protected function walkQueue()
    {
    }
}
