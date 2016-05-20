<?php

namespace Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Model\Attribute;
use Luni\Component\MagentoDriver\Model\CatalogAttribute;
use Luni\Component\MagentoDriver\Model\CatalogAttributeExtension;
use Luni\Component\MagentoDriver\Model\CatalogAttributeExtensionInterface;
use Luni\Component\MagentoDriver\Model\FamilyInterface;
use Luni\Component\MagentoDriver\Entity\Product\ProductInterface;
use Luni\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilderInterface;
use Luni\Component\MagentoDriver\Repository\ProductAttributeRepositoryInterface;

class CatalogAttributeRepository implements ProductAttributeRepositoryInterface
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
     *
     * @param Connection                            $connection
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
     *
     * @return CatalogAttributeExtensionInterface
     */
    protected function createNewAttributeInstanceFromDatabase(array $options)
    {
        return new CatalogAttribute(
            Attribute::buildNewWith(
                isset($options['attribute_id'])    ? $options['attribute_id']           : null,
                isset($options['entity_type_id'])  ? $options['entity_type_id']         : null,
                isset($options['attribute_code'])  ? $options['attribute_code']         : null,
                isset($options['attribute_model']) ? $options['attribute_model']        : null,
                isset($options['backend_type'])    ? $options['backend_type']           : null,
                isset($options['backend_model'])   ? $options['backend_model']          : null,
                isset($options['backend_table'])   ? $options['backend_table']          : null,
                isset($options['frontend_type'])   ? $options['frontend_type']          : null,
                isset($options['frontend_model'])  ? $options['frontend_model']         : null,
                isset($options['frontend_input'])  ? $options['frontend_input']         : null,
                isset($options['frontend_label'])  ? $options['frontend_label']         : null,
                isset($options['frontend_class'])  ? $options['frontend_class']         : null,
                isset($options['source_model'])    ? $options['source_model']           : null,
                isset($options['is_required'])     ? (bool) $options['is_required']     : false,
                isset($options['is_user_defined']) ? (bool) $options['is_user_defined'] : false,
                isset($options['is_unique'])       ? (bool) $options['is_unique']       : false,
                isset($options['default_value'])   ? $options['default_value']          : null
            ),
            new CatalogAttributeExtension(
                isset($options['attribute_id'])                  ? $options['attribute_id']                         : null,
                isset($options['frontend_input_renderer'])       ? $options['frontend_input_renderer']              : null,
                isset($options['is_global'])                     ? (bool) $options['is_global']                     : 1,
                isset($options['is_visible'])                    ? (bool) $options['is_visible']                    : false,
                isset($options['is_searchable'])                 ? (bool) $options['is_searchable']                 : false,
                isset($options['is_filterable'])                 ? (bool) $options['is_filterable']                 : false,
                isset($options['is_comparable'])                 ? (bool) $options['is_comparable']                 : false,
                isset($options['is_visible_on_front'])           ? (bool) $options['is_visible_on_front']           : false,
                isset($options['is_html_allowed_on_front'])      ? (bool) $options['is_html_allowed_on_front']      : false,
                isset($options['is_used_for_price_rules'])       ? (bool) $options['is_used_for_price_rules']       : false,
                isset($options['is_filterable_in_search'])       ? (bool) $options['is_filterable_in_search']       : false,
                isset($options['used_in_product_listing'])       ? (bool) $options['used_in_product_listing']       : false,
                isset($options['used_for_sort_by'])              ? (bool) $options['used_for_sort_by']              : false,
                isset($options['is_configurable'])               ? (bool) $options['is_configurable']               : false, // Magento 1
                isset($options['is_visible_in_advanced_search']) ? (bool) $options['is_visible_in_advanced_search'] : false,
                isset($options['is_wysiwyg_enabled'])            ? (bool) $options['is_wysiwyg_enabled']            : false,
                isset($options['is_used_for_promo_rules'])       ? (bool) $options['is_used_for_promo_rules']       : false,
                $requiredInAdminStore = false,                          // Magento 2
                $usedInGrid = false,                                    // Magento 2
                $visibleInGrid = false,                                 // Magento 2
                $filterableInGrid = false,                              // Magento 2
                isset($options['position'])                      ? (bool) $options['position']                      : 1,
                $searchWeight = false,                                  // Magento 2
                $applyTo = [],                                          // Magento 2
                $additionalData = [],                                   // Magento 2
                isset($options['note']) ? $options['note'] : null
            )
        );
    }

    /**
     * @param string $code
     * @param string $entityTypeCode
     *
     * @return CatalogAttributeExtensionInterface
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
     * @param int $id
     *
     * @return CatalogAttributeExtensionInterface
     */
    public function findOneById($id)
    {
        $query = $this->queryBuilder->createFindOneByIdQueryBuilder('a', 'x');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$id])) {
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
     * @return Collection|CatalogAttributeExtensionInterface[]
     */
    public function findAllByCode($entityTypeCode, array $codeList)
    {
        $query = $this->queryBuilder->createFindAllByCodeQueryBuilder('a', 'x', 'e', $codeList);

        $statement = $this->connection->prepare($query);
        if (!$statement->execute(array_merge([$entityTypeCode], $codeList))) {
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
     *
     * @return Collection|CatalogAttributeExtensionInterface[]
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
     * @return Collection|CatalogAttributeExtensionInterface[]
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
     *
     * @return Collection|CatalogAttributeExtensionInterface[]
     */
    public function findAllByEntity(ProductInterface $product)
    {
        return $this->findAllByFamily($product->getFamily());
    }

    /**
     * @param string $entityTypeCode
     *
     * @return Collection|CatalogAttributeExtensionInterface[]
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
     *
     * @return Collection|CatalogAttributeExtensionInterface[]
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
     *
     * @return Collection|CatalogAttributeExtensionInterface[]
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
     *
     * @return Collection|CatalogAttributeExtensionInterface[]
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
     *
     * @return Collection|CatalogAttributeExtensionInterface[]
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
