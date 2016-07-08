<?php

namespace Kiboko\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeValueInterface;
use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoDriver\Factory\AttributeValueFactoryInterface;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeValueQueryBuilderInterface;
use Kiboko\Component\MagentoDriver\Repository\AttributeRepositoryInterface;
use Kiboko\Component\MagentoDriver\Repository\ProductAttributeValueRepositoryBackendInterface;

/**
 * Class ProductAttributeValueRepository.
 */
class ProductAttributeValueRepository implements ProductAttributeValueRepositoryBackendInterface
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
     *
     * @param Connection                                 $connection
     * @param ProductAttributeValueQueryBuilderInterface $queryBuilder
     * @param AttributeRepositoryInterface               $attributeRepository
     * @param AttributeValueFactoryInterface             $valueFactory
     */
    public function __construct(
        Connection $connection,
        ProductAttributeValueQueryBuilderInterface $queryBuilder,
        AttributeRepositoryInterface $attributeRepository,
        AttributeValueFactoryInterface $valueFactory
    ) {
        $this->connection = $connection;
        $this->queryBuilder = $queryBuilder;
        $this->attributeRepository = $attributeRepository;
        $this->valueFactory = $valueFactory;
    }

    /**
     * @param array $options
     *
     * @return AttributeValueInterface
     */
    protected function createNewAttributeValueInstanceFromDatabase(array $options)
    {
        $attributeId = isset($options['attribute_id']) ? $options['attribute_id'] : null;
        unset($options['attribute_id']);

        $attribute = $this->attributeRepository->findOneById($attributeId);
        if (!$attribute) {
            return;
        }

        return $this->valueFactory->buildNew($attribute, $options);
    }

    /**
     * @param int $valueId
     *
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
            return;
        }

        $options = $statement->fetch();

        return $this->createNewAttributeValueInstanceFromDatabase($options);
    }

    /**
     * @param array|int[] $idList
     *
     * @return \Traversable|AttributeValueInterface[]
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
     *
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllByProduct(ProductInterface $product)
    {
        $query = $this->queryBuilder->createFindAllByProductIdQueryBuilder('v');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$product->getId()])) {
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
     *
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllVariantAxisByProductFromDefault(ProductInterface $product)
    {
        return $this->findAllVariantAxisByProductFromStoreId($product, 0);
    }

    /**
     * @param ProductInterface $product
     * @param int              $storeId
     *
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllVariantAxisByProductFromStoreId(ProductInterface $product, $storeId)
    {
        if ($storeId === 0) {
            $query = $this->queryBuilder->createFindAllVariantAxisByProductIdFromStoreIdQueryBuilder('v', 'va');
        } else {
            $query = $this->queryBuilder->createFindAllVariantAxisByProductIdFromStoreIdOrDefaultQueryBuilder('v', 'l', 'va');
        }

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$storeId, $product->getId()])) {
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
     * @param ProductInterface   $product
     * @param AttributeInterface $attribute
     *
     * @return AttributeValueInterface
     */
    public function findOneByProductAndAttributeFromDefault(
        ProductInterface $product,
        AttributeInterface $attribute
    ) {
        return $this->findOneByProductAndAttributeFromStoreId($product, $attribute, 0);
    }

    /**
     * @param ProductInterface   $product
     * @param AttributeInterface $attribute
     * @param int                $storeId
     *
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
        if (!$statement->execute([$storeId, $product->getId(), $attribute->getId()])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewAttributeValueInstanceFromDatabase($options);
    }

    /**
     * @param ProductInterface $product
     * @param array            $attributeList
     *
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllByProductAndAttributeListFromDefault(
        ProductInterface $product,
        array $attributeList
    ) {
        return $this->findAllByProductAndAttributeListFromStoreId($product, $attributeList, 0);
    }

    /**
     * @param ProductInterface $product
     * @param array            $attributeList
     * @param int              $storeId
     *
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllByProductAndAttributeListFromStoreId(
        ProductInterface $product,
        array $attributeList,
        $storeId
    ) {
        if ($storeId === 0) {
            $query = $this->queryBuilder->createFindAllByProductIdFromStoreIdQueryBuilder('v');
        } else {
            $query = $this->queryBuilder->createFindAllByProductIdFromStoreIdOrDefaultQueryBuilder('v', 'l');
        }

        $attributeIdList = array_map(function (AttributeInterface $item) {
            return $item->getId();
        }, $attributeList);

        $expr = array_pad([], count($attributeIdList), $query->expr()->eq('v.attribute_id', '?'));
        $query->andWhere($query->expr()->orX(...$expr));

        $statement = $this->connection->prepare($query);
        if (!$statement->execute(array_merge([$storeId, $product->getId()], $attributeIdList))) {
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
     * @param array $productList
     *
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllByProductListFromDefault(
        array $productList
    ) {
        return $this->findAllByProductListFromStoreId($productList, 0);
    }

    /**
     * @param array $productList
     * @param int   $storeId
     *
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllByProductListFromStoreId(
        array $productList,
        $storeId
    ) {
        if ($storeId === 0) {
            $query = $this->queryBuilder->createFindAllFromStoreIdQueryBuilder('v');
        } else {
            $query = $this->queryBuilder->createFindAllFromStoreIdOrDefaultQueryBuilder('v', 'l');
        }

        $productIdList = array_map(function (ProductInterface $item) {
            return $item->getId();
        }, $productList);

        $expr = array_pad([], count($productIdList), $query->expr()->eq('v.entity_id', '?'));
        $query->andWhere($query->expr()->orX(...$expr));

        $statement = $this->connection->prepare($query);
        if (!$statement->execute(array_merge([$storeId], $productIdList))) {
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
     * @param array $productList
     * @param array $attributeList
     *
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllByProductListAndAttributeListFromDefault(
        array $productList,
        array $attributeList
    ) {
        return $this->findAllByProductListAndAttributeListFromStoreId($productList, $attributeList, 0);
    }

    /**
     * @param array $productList
     * @param array $attributeList
     * @param int   $storeId
     *
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllByProductListAndAttributeListFromStoreId(
        array $productList,
        array $attributeList,
        $storeId
    ) {
        if ($storeId === 0) {
            $query = $this->queryBuilder->createFindAllFromStoreIdQueryBuilder('v');
        } else {
            $query = $this->queryBuilder->createFindAllFromStoreIdOrDefaultQueryBuilder('v', 'l');
        }

        $productIdList = array_map(function (ProductInterface $item) {
            return $item->getId();
        }, $productList);

        $expr = array_pad([], count($productIdList), $query->expr()->eq('v.entity_id', '?'));
        $query->andWhere($query->expr()->orX(...$expr));

        $attributeIdList = array_map(function (AttributeInterface $item) {
            return $item->getId();
        }, $attributeList);

        $expr = array_pad([], count($attributeIdList), $query->expr()->eq('v.attribute_id', '?'));
        $query->andWhere($query->expr()->orX(...$expr));

        $statement = $this->connection->prepare($query);
        if (!$statement->execute(array_merge([$storeId], $productIdList, $attributeIdList))) {
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
     *
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllByProductFromDefault(ProductInterface $product)
    {
        return $this->findAllByProductFromStoreId($product, 0);
    }

    /**
     * @param ProductInterface $product
     * @param int              $storeId
     *
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllByProductFromStoreId(ProductInterface $product, $storeId)
    {
        if ($storeId === 0) {
            $query = $this->queryBuilder->createFindAllByProductIdFromStoreIdQueryBuilder('v');
        } else {
            $query = $this->queryBuilder->createFindAllByProductIdFromStoreIdOrDefaultQueryBuilder('v', 'l');
        }

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$storeId, $product->getId()])) {
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
