<?php

namespace Luni\Component\MagentoDriver\Persister\FlatFile\Attribute;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Persister\AttributePersisterInterface;
use Luni\Component\MagentoDriver\Persister\BaseFlatFilePersisterTrait;
use Luni\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Luni\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;

class StandardAttributePersister
    implements AttributePersisterInterface
{
    use BaseFlatFilePersisterTrait;

    /**
     * @param TemporaryWriterInterface $temporaryWriter
     * @param DatabaseWriterInterface $databaseWriter
     * @param string $tableName
     * @param array $tableKeys
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

    /**
     * @return void
     */
    public function initialize()
    {
    }

    /**
     * @param AttributeInterface $attribute
     */
    public function persist(AttributeInterface $attribute)
    {
        $this->temporaryWriter->persistRow([
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
        ]);
    }

    public function __invoke(AttributeInterface $attribute)
    {
        $this->persist($attribute);
    }

    /**
     * @return void
     */
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
