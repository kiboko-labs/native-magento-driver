<?php

namespace Luni\Component\MagentoDriver\Persister\FlatFile\SuperLink;

use Luni\Component\MagentoDriver\Model\SuperLinkInterface;
use Luni\Component\MagentoDriver\Persister\BaseFlatFilePersisterTrait;
use Luni\Component\MagentoDriver\Persister\SuperLinkPersisterInterface;
use Luni\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Luni\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;

class ProductSuperLinkPersister implements SuperLinkPersisterInterface
{
    use BaseFlatFilePersisterTrait;

    /**
     * @var \SplQueue
     */
    private $superLinkQueue;

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
        $this->superLinkQueue = new \SplQueue();
    }

    public function initialize()
    {
    }

    /**
     * @param SuperLinkInterface $superLink
     */
    public function persist(SuperLinkInterface $superLink)
    {
        if ($superLink->getId() === null) {
            $this->superLinkQueue->enqueue($superLink);
        }

        $this->temporaryWriter->persistRow([
            'link_id' => $superLink->getId(),
            'parent_id' => $superLink->getConfigurableId(),
            'product_id' => $superLink->getVariantId(),
        ]);
    }

    /**
     * @param SuperLinkInterface $superLink
     */
    public function __invoke(SuperLinkInterface $superLink)
    {
        $this->persist($superLink);
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
        while ($this->superLinkQueue->count() > 0 && $id = yield) {
            /** @var SuperLinkInterface $superLink */
            $superLink = $this->superLinkQueue->dequeue();
            $superLink->persistedToId($id);
        }
    }
}
