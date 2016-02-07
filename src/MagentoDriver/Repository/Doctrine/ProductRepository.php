<?php

namespace Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Entity\CategoryInterface;
use Luni\Component\MagentoDriver\Entity\ProductInterface;
use Luni\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Luni\Component\MagentoDriver\Factory\ProductFactoryInterface;
use Luni\Component\MagentoDriver\Model\FamilyInterface;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\ProductQueryBuilderInterface;
use Luni\Component\MagentoDriver\Repository\ProductRepositoryInterface;

class ProductRepository
    implements ProductRepositoryInterface
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
     * @param Connection $connection
     * @param ProductQueryBuilderInterface $queryBuilder
     * @param ProductFactoryInterface $productFactory
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
     * @return ProductInterface
     */
    protected function createNewProductInstanceFromDatabase(array $options)
    {
        $type = isset($options['type_id']) ? $options['type_id'] : null;
        unset($options['type_id']);

        $product = $this->productFactory->buildNew($type, $options);

        return $product;
    }

    /**
     * @param string $code
     * @return ProductInterface
     */
    public function findOneByIdentifier($code)
    {
        $query = $this->queryBuilder->createFindOneByIdentifierQueryBuilder('p');

        $statement = $this->connection->prepare($query);
        $statement->bindValue(1, $code);

        if (!$statement->execute()) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return null;
        }

        $options = $statement->fetch();
        return $this->createNewProductInstanceFromDatabase($options);
    }

    /**
     * @param int $id
     * @return ProductInterface
     */
    public function findOneById($id)
    {
        $query = $this->queryBuilder->createFindOneByIdQueryBuilder('p');

        $statement = $this->connection->prepare($query);

        if (!$statement->execute([$id])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return null;
        }

        $options = $statement->fetch();
        return $this->createNewProductInstanceFromDatabase($options);
    }

    /**
     * @param array $identifierList
     * @return Collection|ProductInterface[]
     */
    public function findAllByIdentifier(array $identifierList)
    {
        $query = $this->queryBuilder->createFindAllByIdentifierQueryBuilder('p', $identifierList);

        $statement = $this->connection->prepare($query);
        if (!$statement->execute($identifierList)) {
            throw new DatabaseFetchingFailureException();
        }

        $productList = new ArrayCollection();
        if ($statement->rowCount() < 1) {
            return $productList;
        }

        foreach ($statement as $options) {
            $productList->set($options['entity_id'], $this->createNewProductInstanceFromDatabase($options));
        }

        return $productList;
    }

    /**
     * @param array|int[] $idList
     * @return Collection|ProductInterface[]
     */
    public function findAllById(array $idList)
    {
        $query = $this->queryBuilder->createFindAllByIdQueryBuilder('p', $idList);

        $statement = $this->connection->prepare($query);
        if (!$statement->execute($idList)) {
            throw new DatabaseFetchingFailureException();
        }

        $productList = new ArrayCollection();
        if ($statement->rowCount() < 1) {
            return $productList;
        }

        foreach ($statement as $options) {
            $productList->set($options['entity_id'], $this->createNewProductInstanceFromDatabase($options));
        }

        return $productList;
    }

    /**
     * @param FamilyInterface $family
     * @return Collection|ProductInterface[]
     */
    public function findAllByFamily(FamilyInterface $family)
    {
        $query = $this->queryBuilder->createFindAllByFamilyQueryBuilder('p', 'f');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$family->getId()])) {
            throw new DatabaseFetchingFailureException();
        }

        $productList = new ArrayCollection();
        if ($statement->rowCount() < 1) {
            return $productList;
        }

        foreach ($statement as $options) {
            $productList->set($options['entity_id'], $this->createNewProductInstanceFromDatabase($options));
        }

        return $productList;
    }

    /**
     * @param CategoryInterface $category
     * @return Collection|ProductInterface[]
     */
    public function findAllByCategory(CategoryInterface $category)
    {
        $query = $this->queryBuilder->createFindAllByCategoryQueryBuilder('p', 'c');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$category->getId()])) {
            throw new DatabaseFetchingFailureException();
        }

        $productList = new ArrayCollection();
        if ($statement->rowCount() < 1) {
            return $productList;
        }

        foreach ($statement as $options) {
            $productList->set($options['entity_id'], $this->createNewProductInstanceFromDatabase($options));
        }

        return $productList;
    }

    /**
     * @param string $productType
     * @return Collection|ProductInterface[]
     */
    public function findAllByType($productType)
    {
        $query = $this->queryBuilder->createFindAllQueryBuilder('p');
        $query->where($query->expr()->eq('p.type_id', '?'));

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$productType])) {
            throw new DatabaseFetchingFailureException();
        }

        $productList = new ArrayCollection();
        if ($statement->rowCount() < 1) {
            return $productList;
        }

        foreach ($statement as $options) {
            $productList->set($options['entity_id'], $this->createNewProductInstanceFromDatabase($options));
        }

        return $productList;
    }

    /**
     * @return Collection|ProductInterface[]
     */
    public function findAll()
    {
        $query = $this->queryBuilder->createFindAllQueryBuilder('p');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute()) {
            throw new DatabaseFetchingFailureException();
        }

        $productList = new ArrayCollection();
        if ($statement->rowCount() < 1) {
            return $productList;
        }

        foreach ($statement as $options) {
            $productList->set($options['entity_id'], $this->createNewProductInstanceFromDatabase($options));
        }

        return $productList;
    }
}
