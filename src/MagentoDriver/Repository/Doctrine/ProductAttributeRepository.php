<?php

namespace Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Model\Attribute;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\FamilyInterface;
use Luni\Component\MagentoDriver\Entity\Product\ProductInterface;
use Luni\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilderInterface;
use Luni\Component\MagentoDriver\Repository\ProductAttributeRepositoryInterface;

/**
 * Class ProductAttributeRepository
 * @package Luni\Component\MagentoDriver\Repository\Doctrine
 */
class ProductAttributeRepository
    implements ProductAttributeRepositoryInterface
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
     * ProductAttributeRepository constructor.
     * @param Connection $connection
     * @param ProductAttributeQueryBuilderInterface $queryBuilder
     */
    public function __construct(
        Connection $connection,
        ProductAttributeQueryBuilderInterface $queryBuilder
    ) {
        $this->connection = $connection;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @param array $options
     * @return AttributeInterface
     */
    protected function createNewAttributeInstanceFromDatabase(array $options)
    {
        $attributeId = isset($options['attribute_id']) ? $options['attribute_id'] : null;
        $attributeCode = isset($options['attribute_code']) ? $options['attribute_code'] : null;
        $backendType = isset($options['backend_type']) ? $options['backend_type'] : null;

        unset(
            $options['attribute_id'],
            $options['attribute_code'],
            $options['backend_type']
        );

        return Attribute::buildNewWith($attributeId, $attributeCode, $backendType, $options);
    }

    /**
     * @param string $entityTypeCode
     * @param string $code
     * @return AttributeInterface
     */
    public function findOneByCode($code, $entityTypeCode)
    {
        $query = $this->queryBuilder->createFindOneByCodeQueryBuilder('a', 'x', 'e');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$entityTypeCode, $code])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return null;
        }

        $options = $statement->fetch();
        return $this->createNewAttributeInstanceFromDatabase($options);
    }

    /**
     * @param int $id
     * @return AttributeInterface
     */
    public function findOneById($id)
    {
        $query = $this->queryBuilder->createFindOneByIdQueryBuilder('a', 'x');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$id])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return null;
        }

        $options = $statement->fetch();
        return $this->createNewAttributeInstanceFromDatabase($options);
    }

    /**
     * @param string $entityTypeCode
     * @param array|string[] $codeList
     * @return Collection|AttributeInterface[]
     */
    public function findAllByCode($entityTypeCode, array $codeList)
    {
        $query = $this->queryBuilder->createFindAllByCodeQueryBuilder('a', 'x', 'e', $codeList);

        $statement = $this->connection->prepare($query);
        if (!$statement->execute(array_merge(['catalog_product'], $codeList))) {
            throw new DatabaseFetchingFailureException();
        }

        $attributeList = new ArrayCollection();
        if ($statement->rowCount() < 1) {
            return $attributeList;
        }

        foreach ($statement as $options) {
            $attributeList->set($options['attribute_code'], $this->createNewAttributeInstanceFromDatabase($options));
        }

        return $attributeList;
    }

    /**
     * @param array|int[] $idList
     * @return Collection|AttributeInterface[]
     */
    public function findAllById(array $idList)
    {
        $query = $this->queryBuilder->createFindAllByIdQueryBuilder('a', 'x', $idList);

        $statement = $this->connection->prepare($query);
        if (!$statement->execute($idList)) {
            throw new DatabaseFetchingFailureException();
        }

        $attributeList = new ArrayCollection();
        if ($statement->rowCount() < 1) {
            return $attributeList;
        }

        foreach ($statement as $options) {
            $attributeList->set($options['attribute_id'], $this->createNewAttributeInstanceFromDatabase($options));
        }

        return $attributeList;
    }

    /**
     * @return Collection|AttributeInterface[]
     */
    public function findAll()
    {
        $query = $this->queryBuilder->createFindAllQueryBuilder('a', 'x');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute()) {
            throw new DatabaseFetchingFailureException();
        }

        $attributeList = new ArrayCollection();
        if ($statement->rowCount() < 1) {
            return $attributeList;
        }

        foreach ($statement as $options) {
            $attributeList->set($options['attribute_code'], $this->createNewAttributeInstanceFromDatabase($options));
        }

        return $attributeList;
    }

    /**
     * @param ProductInterface $product
     * @return Collection|AttributeInterface[]
     */
    public function findAllByEntity(ProductInterface $product)
    {
        return $this->findAllByFamily($product->getFamily());
    }

    /**
     * @param string $entityTypeCode
     * @return Collection|AttributeInterface[]
     */
    public function findAllByEntityTypeCode($entityTypeCode)
    {
        $query = $this->queryBuilder->createFindAllQueryBuilder('a', 'x');

        $attributeList = new ArrayCollection();
        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$entityTypeCode])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return $attributeList;
        }

        foreach ($statement as $options) {
            $attributeList->set($options['attribute_code'], $this->createNewAttributeInstanceFromDatabase($options));
        }

        return $attributeList;
    }

    /**
     * @param int $entityTypeId
     * @return Collection|AttributeInterface[]
     */
    public function findAllByEntityTypeId($entityTypeId)
    {
        $query = $this->queryBuilder->createFindAllQueryBuilder('a', 'x');

        $query->where($query->expr()->eq('a.entity_type_id', '?'));

        $attributeList = new ArrayCollection();
        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$entityTypeId])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return $attributeList;
        }

        foreach ($statement as $options) {
            $attributeList->set($options['attribute_code'], $this->createNewAttributeInstanceFromDatabase($options));
        }

        return $attributeList;
    }

    /**
     * @param ProductInterface $product
     * @return Collection|AttributeInterface[]
     */
    public function findAllVariantAxisByEntity(ProductInterface $product)
    {
        $attributeList = new ArrayCollection();
        if (!$product->isConfigurable()) {
            return $attributeList;
        }

        $query = $this->queryBuilder->createFindAllVariantAxisByEntityQueryBuilder('a', 'x', 'e', 'va');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$product->getId()])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return $attributeList;
        }

        foreach ($statement as $options) {
            $attributeList->set($options['attribute_code'], $this->createNewAttributeInstanceFromDatabase($options));
        }

        return $attributeList;
    }

    /**
     * @param FamilyInterface $family
     * @return Collection|AttributeInterface[]
     */
    public function findAllByFamily(FamilyInterface $family)
    {
        $query = $this->queryBuilder->createFindAllByFamilyQueryBuilder('a', 'x', 'e', 'f');

        $attributeList = new ArrayCollection();
        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$family->getId()])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return $attributeList;
        }

        foreach ($statement as $options) {
            $attributeList->set($options['attribute_code'], $this->createNewAttributeInstanceFromDatabase($options));
        }

        return $attributeList;
    }

    /**
     * @param FamilyInterface $family
     * @return Collection|AttributeInterface[]
     */
    public function findAllMandatoryByFamily(FamilyInterface $family)
    {
        $query = $this->queryBuilder->createFindAllMandatoryByFamilyQueryBuilder('a', 'x', 'e', 'f');

        $attributeList = new ArrayCollection();
        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$family->getId()])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return $attributeList;
        }

        foreach ($statement as $options) {
            $attributeList->set($options['attribute_code'], $this->createNewAttributeInstanceFromDatabase($options));
        }

        return $attributeList;
    }
}
