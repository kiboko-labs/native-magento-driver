<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\Factory\ProductAttributeFactoryInterface;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Model\CatalogAttributeExtensionInterface;
use Kiboko\Component\MagentoORM\Model\FamilyInterface;
use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoORM\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\ProductAttributeQueryBuilderInterface;
use Kiboko\Component\MagentoORM\Repository\ProductAttributeRepositoryInterface;

class ProductAttributeRepository implements ProductAttributeRepositoryInterface
{
    /**
     * @var ProductAttributeQueryBuilderInterface
     */
    protected $queryBuilder;

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var ProductAttributeFactoryInterface
     */
    protected $factory;

    /**
     * ProductAttributeRepository constructor.
     *
     * @param Connection                            $connection
     * @param ProductAttributeQueryBuilderInterface $queryBuilder
     * @param ProductAttributeFactoryInterface      $factory
     */
    public function __construct(
        Connection $connection,
        ProductAttributeQueryBuilderInterface $queryBuilder,
        ProductAttributeFactoryInterface $factory
    ) {
        $this->connection = $connection;
        $this->queryBuilder = $queryBuilder;
        $this->factory = $factory;
    }

    /**
     * @param array $options
     *
     * @return AttributeInterface
     */
    protected function createNewAttributeInstanceFromDatabase(array $options)
    {
        return $this->factory->buildNew($options);
    }

    /**
     * @param string $code
     * @param string $entityTypeCode
     *
     * @return AttributeInterface|CatalogAttributeExtensionInterface
     */
    public function findOneByCode($code, $entityTypeCode)
    {
        $query = $this->queryBuilder->createFindOneByCodeQueryBuilder('a', 'x', 'e');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$entityTypeCode, $code])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewAttributeInstanceFromDatabase($options);
    }

    /**
     * @param int $identifier
     *
     * @return AttributeInterface|CatalogAttributeExtensionInterface
     */
    public function findOneById($identifier)
    {
        $query = $this->queryBuilder->createFindOneByIdQueryBuilder('a', 'x');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$identifier])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewAttributeInstanceFromDatabase($options);
    }

    /**
     * @param string         $entityTypeCode
     * @param array|string[] $codeList
     *
     * @return \Traversable|AttributeInterface[]|CatalogAttributeExtensionInterface[]
     */
    public function findAllByCode($entityTypeCode, array $codeList)
    {
        $query = $this->queryBuilder->createFindAllByCodeQueryBuilder('a', 'e', $codeList);

        $statement = $this->connection->prepare($query);
        if (!$statement->execute(array_merge([$entityTypeCode], $codeList))) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        foreach ($statement as $options) {
            yield $options['attribute_code'] => $this->createNewAttributeInstanceFromDatabase($options);
        }
    }

    /**
     * @param array|int[] $idList
     *
     * @return \Traversable|AttributeInterface[]|CatalogAttributeExtensionInterface[]
     */
    public function findAllById(array $idList)
    {
        $query = $this->queryBuilder->createFindAllByIdQueryBuilder('a', $idList);

        $statement = $this->connection->prepare($query);
        if (!$statement->execute($idList)) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        foreach ($statement as $options) {
            yield $options['attribute_id'] => $this->createNewAttributeInstanceFromDatabase($options);
        }
    }

    /**
     * @return \Traversable|AttributeInterface[]|CatalogAttributeExtensionInterface[]
     */
    public function findAll()
    {
        $query = $this->queryBuilder->createFindAllQueryBuilder('a');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute()) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        foreach ($statement as $options) {
            yield $options['attribute_code'] => $this->createNewAttributeInstanceFromDatabase($options);
        }
    }

    /**
     * @param ProductInterface $product
     *
     * @return \Traversable|AttributeInterface[]|CatalogAttributeExtensionInterface[]
     */
    public function findAllByEntity(ProductInterface $product)
    {
        return $this->findAllByFamily($product->getFamily());
    }

    /**
     * @param string $entityTypeCode
     *
     * @return \Traversable|AttributeInterface[]|CatalogAttributeExtensionInterface[]
     */
    public function findAllByEntityTypeCode($entityTypeCode)
    {
        $query = $this->queryBuilder->createFindAllByEntityTypeQueryBuilder('a', 'e');

        $query->where($query->expr()->eq('e.entity_type_code', '?'));

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$entityTypeCode])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        foreach ($statement as $options) {
            yield $options['attribute_code'] => $this->createNewAttributeInstanceFromDatabase($options);
        }
    }

    /**
     * @param int $entityTypeId
     *
     * @return \Traversable|AttributeInterface[]|CatalogAttributeExtensionInterface[]
     */
    public function findAllByEntityTypeId($entityTypeId)
    {
        $query = $this->queryBuilder->createFindAllQueryBuilder('a');

        $query->where($query->expr()->eq('a.entity_type_id', '?'));

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$entityTypeId])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        foreach ($statement as $options) {
            yield $options['attribute_code'] => $this->createNewAttributeInstanceFromDatabase($options);
        }
    }

    /**
     * @param ProductInterface $product
     *
     * @return \Traversable|AttributeInterface[]|CatalogAttributeExtensionInterface[]
     */
    public function findAllVariantAxisByEntity(ProductInterface $product)
    {
        if (!$product->isConfigurable()) {
            return;
        }

        $query = $this->queryBuilder->createFindAllVariantAxisByEntityQueryBuilderWithExtra('a', 'x', 'e', 'va');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$product->getIdentifier()])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        foreach ($statement as $options) {
            yield $options['attribute_code'] => $this->createNewAttributeInstanceFromDatabase($options);
        }
    }

    /**
     * @param FamilyInterface $family
     *
     * @return \Traversable|AttributeInterface[]|CatalogAttributeExtensionInterface[]
     */
    public function findAllByFamily(FamilyInterface $family)
    {
        $query = $this->queryBuilder->createFindAllByFamilyQueryBuilderWithExtra('a', 'x', 'e', 'f');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute(['catalog_product', $family->getId()])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        foreach ($statement as $options) {
            yield $options['attribute_code'] => $this->createNewAttributeInstanceFromDatabase($options);
        }
    }

    /**
     * @param FamilyInterface $family
     *
     * @return \Traversable|AttributeInterface[]|CatalogAttributeExtensionInterface[]
     */
    public function findAllMandatoryByFamily(FamilyInterface $family)
    {
        $query = $this->queryBuilder->createFindAllMandatoryByFamilyQueryBuilderWithExtra('a', 'x', 'e', 'f');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute(['catalog_product', $family->getId()])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        foreach ($statement as $options) {
            yield $options['attribute_code'] => $this->createNewAttributeInstanceFromDatabase($options);
        }
    }
}
