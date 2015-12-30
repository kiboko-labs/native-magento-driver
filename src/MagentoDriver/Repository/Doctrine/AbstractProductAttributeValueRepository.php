<?php

namespace Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\AttributeValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\Entity\ProductInterface;
use Luni\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Luni\Component\MagentoDriver\Exception\RuntimeErrorException;
use Luni\Component\MagentoDriver\Factory\AttributeValueFactoryInterface;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeValueQueryBuilderInterface;
use Luni\Component\MagentoDriver\Repository\AttributeRepositoryInterface;
use Luni\Component\MagentoDriver\Repository\ProductAttributeValueRepositoryInterface;

abstract class AbstractProductAttributeValueRepository
    implements ProductAttributeValueRepositoryInterface
{
    /**
     * @var ProductAttributeValueQueryBuilderInterface
     */
    protected $queryBuilder;

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var AttributeValueFactoryInterface
     */
    protected $valueFactory;

    /**
     * @var AttributeRepositoryInterface
     */
    protected $attributeRepository;

    /**
     * ProductAttributeRepository constructor.
     * @param Connection $connection
     * @param ProductAttributeValueQueryBuilderInterface $queryBuilder
     * @param AttributeValueFactoryInterface $valueFactory
     */
    public function __construct(
        Connection $connection,
        ProductAttributeValueQueryBuilderInterface $queryBuilder,
        AttributeValueFactoryInterface $valueFactory
    ) {
        $this->connection = $connection;
        $this->queryBuilder = $queryBuilder;
        $this->valueFactory = $valueFactory;
    }

    /**
     * @param array $options
     * @return AttributeValueInterface
     */
    abstract protected function createNewAttributeValueInstanceFromDatabase(array $options);

    /**
     * @param int $valueId
     * @return AttributeValueInterface
     */
    public function findOneById($valueId)
    {
        $query = $this->queryBuilder->createFindOneByIdQueryBuilder('v');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$valueId])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return null;
        }

        $options = $statement->fetch();
        return $this->createNewAttributeValueInstanceFromDatabase($options);
    }

    /**
     * @param array|int[] $idList
     * @return Collection|AttributeValueInterface[]
     */
    public function findAllById(array $idList)
    {
        $query = $this->queryBuilder->createFindAllByIdQueryBuilder('v', $idList);

        $statement = $this->connection->prepare($query);
        if (!$statement->execute($idList)) {
            throw new DatabaseFetchingFailureException();
        }

        $attributeList = new ArrayCollection();
        if ($statement->rowCount() < 1) {
            return $attributeList;
        }

        foreach ($statement as $options) {
            $attributeList->set($options['value_id'], $this->createNewAttributeValueInstanceFromDatabase($options));
        }

        return $attributeList;
    }

    /**
     * @param ProductInterface $product
     * @return Collection|AttributeValueInterface[]
     */
    public function findAllByProduct(ProductInterface $product)
    {
        $query = $this->queryBuilder->createFindAllByProductIdQueryBuilder('v');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([
            ':product_id' => $product->getId(),
        ])) {
            throw new DatabaseFetchingFailureException();
        }

        $attributeValueList = new ArrayCollection();
        if ($statement->rowCount() < 1) {
            return $attributeValueList;
        }

        foreach ($statement as $options) {
            $attributeValueList->set($options['value_id'], $this->createNewAttributeValueInstanceFromDatabase($options));
        }

        return $attributeValueList;
    }

    /**
     * @param ProductInterface $product
     * @return Collection|AttributeValueInterface[]
     */
    public function findAllVariantAxisByProduct(ProductInterface $product)
    {
        throw new RuntimeErrorException('Not yet implemented.');
    }

    /**
     * @param ProductInterface $product
     * @return Collection|AttributeValueInterface[]
     */
    public function findAllMandatoryByProduct(ProductInterface $product)
    {
        throw new RuntimeErrorException('Not yet implemented.');
    }

    /**
     * @param ProductInterface $product
     * @param AttributeInterface $attribute
     * @return AttributeValueInterface
     */
    public function findOneByProductAndAttributeFromDefault(
        ProductInterface $product,
        AttributeInterface $attribute
    ) {
        return $this->findOneByProductAndAttributeFromStoreId($product, $attribute, 0);
    }

    /**
     * @param ProductInterface $product
     * @param AttributeInterface $attribute
     * @param int $storeId
     * @return AttributeValueInterface
     */
    public function findOneByProductAndAttributeFromStoreId(
        ProductInterface $product,
        AttributeInterface $attribute,
        $storeId
    ) {
        if ($storeId === 0) {
            $query = $this->queryBuilder->createFindOneByProductIdAndAttributeIdFromStoreIdQueryBuilder('v');
        } else {
            $query = $this->queryBuilder->createFindOneByProductIdAndAttributeIdFromStoreIdOrDefaultQueryBuilder('v', 'l');
        }

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([
            ':store_id'     => $storeId,
            ':product_id'   => $product->getId(),
            ':attribute_id' => $attribute->getId(),
        ])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return null;
        }

        $options = $statement->fetch();
        return $this->createNewAttributeValueInstanceFromDatabase($options);
    }

    /**
     * @param ProductInterface $product
     * @return Collection|AttributeValueInterface[]
     */
    public function findAllByProductFromDefault(ProductInterface $product)
    {
        return $this->findAllByProductFromStoreId($product, 0);
    }

    /**
     * @param ProductInterface $product
     * @param int $storeId
     * @return Collection|AttributeValueInterface[]
     */
    public function findAllByProductFromStoreId(ProductInterface $product, $storeId)
    {
        if ($storeId === 0) {
            $query = $this->queryBuilder->createFindAllByProductIdFromStoreIdQueryBuilder('v');
        } else {
            $query = $this->queryBuilder->createFindAllByProductIdFromStoreIdOrDefaultQueryBuilder('v', 'l');
        }

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([
            ':store_id'   => $storeId,
            ':product_id' => $product->getId(),
        ])) {
            throw new DatabaseFetchingFailureException();
        }

        $attributeValueList = new ArrayCollection();
        if ($statement->rowCount() < 1) {
            return $attributeValueList;
        }

        foreach ($statement as $options) {
            $attributeValueList->set($options['value_id'], $this->createNewAttributeValueInstanceFromDatabase($options));
        }

        return $attributeValueList;
    }
}