<?php

namespace Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Luni\Component\MagentoDriver\Entity\CategoryInterface;
use Luni\Component\MagentoDriver\Entity\ProductInterface;
use Luni\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Luni\Component\MagentoDriver\Factory\ProductFactoryInterface;
use Luni\Component\MagentoDriver\Family\FamilyInterface;
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
     * ProductAttributeRepository constructor.
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
        $statement->bindValue('sku', $code);

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
        // TODO: Implement findAllByIdentifier() method.
    }

    /**
     * @param array|int[] $idList
     * @return Collection|ProductInterface[]
     */
    public function findAllById(array $idList)
    {
        // TODO: Implement findAllById() method.
    }

    /**
     * @param FamilyInterface $family
     * @return Collection|ProductInterface[]
     */
    public function findAllByFamily(FamilyInterface $family)
    {
        // TODO: Implement findAllByFamily() method.
    }

    /**
     * @param CategoryInterface $category
     * @return Collection|ProductInterface[]
     */
    public function findAllByCategory(CategoryInterface $category)
    {
        // TODO: Implement findAllByCategory() method.
    }

    /**
     * @return Collection|ProductInterface[]
     */
    public function findAll()
    {
        // TODO: Implement findAll() method.
    }
}