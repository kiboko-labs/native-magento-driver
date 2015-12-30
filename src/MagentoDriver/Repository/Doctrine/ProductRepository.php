<?php

namespace Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Entity\ProductInterface;
use Luni\Component\MagentoDriver\Family\FamilyInterface;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\ProductQueryBuilderInterface;
use Luni\Component\MagentoDriver\Repository\ProductRepositoryInterface;

class ProductRepository
    implements ProductRepositoryInterface
{
    /**
     * @var ProductQueryBuilderInterface
     */
    protected $queryBuilder;

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * ProductAttributeRepository constructor.
     * @param Connection $connection
     * @param ProductQueryBuilderInterface $queryBuilder
     */
    public function __construct(
        Connection $connection,
        ProductQueryBuilderInterface $queryBuilder
    ) {
        $this->connection = $connection;
        $this->queryBuilder = $queryBuilder;

        $this->attributeCacheByCode = new ArrayCollection();
        $this->attributeCacheById = new ArrayCollection();
    }

    /**
     * @param string $code
     * @return ProductInterface
     */
    public function findOneByIdentifier($code)
    {
        // TODO: Implement findOneByIdentifier() method.
    }

    /**
     * @param int $id
     * @return ProductInterface
     */
    public function findOneById($id)
    {
        // TODO: Implement findOneById() method.
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
     * @return Collection|ProductInterface[]
     */
    public function findAll()
    {
        // TODO: Implement findAll() method.
    }
}