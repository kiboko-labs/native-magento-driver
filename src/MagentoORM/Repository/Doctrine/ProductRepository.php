<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\Entity\CategoryInterface;
use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoORM\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoORM\Factory\ProductFactoryInterface;
use Kiboko\Component\MagentoORM\Model\FamilyInterface;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\ProductQueryBuilderInterface;
use Kiboko\Component\MagentoORM\Repository\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var ProductQueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var ProductFactoryInterface
     */
    private $productFactory;

    /**
     * @param Connection                   $connection
     * @param ProductQueryBuilderInterface $queryBuilder
     * @param ProductFactoryInterface      $productFactory
     */
    public function __construct(
        Connection $connection,
        ProductQueryBuilderInterface $queryBuilder,
        ProductFactoryInterface $productFactory
    ) {
        $this->connection = $connection;
        $this->queryBuilder = $queryBuilder;
        $this->productFactory = $productFactory;
    }

    /**
     * @param array $options
     *
     * @return ProductInterface
     */
    protected function createNewProductInstanceFromDatabase(array $options)
    {
        $product = $this->productFactory->buildNew($options);

        return $product;
    }

    /**
     * @param string $identifier
     *
     * @return ProductInterface
     */
    public function findOneById($identifier)
    {
        $query = $this->queryBuilder->createFindOneByIdQueryBuilder('p');

        $statement = $this->connection->prepare($query);
        $statement->bindValue(1, $identifier);

        if (!$statement->execute()) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewProductInstanceFromDatabase($options);
    }

    /**
     * @param int $code
     *
     * @return ProductInterface
     */
    public function findOneByIdentifier($code)
    {
        $query = $this->queryBuilder->createFindOneByIdentifierQueryBuilder('p');

        $statement = $this->connection->prepare($query);

        if (!$statement->execute([$code])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewProductInstanceFromDatabase($options);
    }

    /**
     * @param array $identifierList
     *
     * @return \Traversable|ProductInterface[]
     */
    public function findAllById(array $identifierList)
    {
        $query = $this->queryBuilder->createFindAllByIdQueryBuilder('p', $identifierList);

        $statement = $this->connection->prepare($query);
        if (!$statement->execute($identifierList)) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        foreach ($statement as $options) {
            yield $options['entity_id'] => $this->createNewProductInstanceFromDatabase($options);
        }
    }

    /**
     * @param array|int[] $codeList
     *
     * @return \Traversable|ProductInterface[]
     */
    public function findAllByIdentifier(array $codeList)
    {
        $query = $this->queryBuilder->createFindAllByIdentifierQueryBuilder('p', $codeList);

        $statement = $this->connection->prepare($query);
        if (!$statement->execute($codeList)) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        foreach ($statement as $options) {
            yield $options['entity_id'] => $this->createNewProductInstanceFromDatabase($options);
        }
    }

    /**
     * @param FamilyInterface $family
     *
     * @return \Traversable|ProductInterface[]
     */
    public function findAllByFamily(FamilyInterface $family)
    {
        $query = $this->queryBuilder->createFindAllByFamilyQueryBuilder('p', 'f');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$family->getId()])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        foreach ($statement as $options) {
            yield $options['entity_id'] => $this->createNewProductInstanceFromDatabase($options);
        }
    }

    /**
     * @param CategoryInterface $category
     *
     * @return \Traversable|ProductInterface[]
     */
    public function findAllByCategory(CategoryInterface $category)
    {
        $query = $this->queryBuilder->createFindAllByCategoryQueryBuilder('p', 'c');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$category->getId()])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        foreach ($statement as $options) {
            yield $options['entity_id'] => $this->createNewProductInstanceFromDatabase($options);
        }
    }

    /**
     * @param string $productType
     *
     * @return \Traversable|ProductInterface[]
     */
    public function findAllByType($productType)
    {
        $query = $this->queryBuilder->createFindAllQueryBuilder('p');
        $query->where($query->expr()->eq('p.type_id', '?'));

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$productType])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        foreach ($statement as $options) {
            yield $options['entity_id'] => $this->createNewProductInstanceFromDatabase($options);
        }
    }

    /**
     * @return \Traversable|ProductInterface[]
     */
    public function findAll()
    {
        $query = $this->queryBuilder->createFindAllQueryBuilder('p');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute()) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        foreach ($statement as $options) {
            yield $options['entity_id'] => $this->createNewProductInstanceFromDatabase($options);
        }
    }
}
