<?php

namespace Luni\Component\MagentoDriver\Backend\Attribute;

use Doctrine\DBAL\Connection;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use Luni\Component\MagentoDriver\AttributeValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\TextAttributeValueInterface;
use Luni\Component\MagentoDriver\Entity\ProductInterface;
use Luni\Component\MagentoDriver\Exception\InvalidAttributeBackendTypeException;

class TextAttributeBackend
    implements BackendInterface
{
    use BaseAttributeCsvBackendTrait;

    /**
     * @param Connection $connection
     * @param string $table
     * @param FilesystemInterface $localFs
     */
    public function __construct(
        Connection $connection,
        $table,
        FilesystemInterface $localFs
    ) {
        $this->connection = $connection;
        $this->table = $table;
        $this->localFs = $localFs;
    }

    /**
     * @param ProductInterface $product
     * @param AttributeValueInterface $value
     */
    public function persist(ProductInterface $product, AttributeValueInterface $value)
    {
        if (!$value instanceof TextAttributeValueInterface) {
            throw new InvalidAttributeBackendTypeException();
        }

        $this->temporaryWriter->persistRow([
            'value_id'       => $value->getId(),
            'entity_type_id' => 4,
            'attribute_id'   => $value->getAttributeId(),
            'store_id'       => $value->getStoreId(),
            'entity_id'      => $product->getId(),
            'value'          => $value->getValue(),
        ]);
    }
}