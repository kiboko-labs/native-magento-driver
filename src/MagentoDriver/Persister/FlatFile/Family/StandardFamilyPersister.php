<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Persister\FlatFile\Family;

use Kiboko\Component\MagentoDriver\Model\FamilyInterface;
use Kiboko\Component\MagentoDriver\Persister\FlatFile\BaseFlatFilePersisterTrait;
use Kiboko\Component\MagentoDriver\Persister\FamilyPersisterInterface;
use Kiboko\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Kiboko\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;

class StandardFamilyPersister implements FamilyPersisterInterface
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
     * @param FamilyInterface $familyInterface
     */
    public function persist(FamilyInterface $familyInterface)
    {
        $this->temporaryWriter->persistRow([
            'attribute_set_id' => $familyInterface->getId(),
            'entity_type_id' => 4,
            'attribute_set_name' => $familyInterface->getLabel(),
            'sort_order' => 0,
        ]);
    }

    /**
     * @param FamilyInterface $family
     */
    public function __invoke(FamilyInterface $family)
    {
        $this->persist($family);
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
