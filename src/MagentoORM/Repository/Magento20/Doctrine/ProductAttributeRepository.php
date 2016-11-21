<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository\Magento20\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\Model\Attribute;
use Kiboko\Component\MagentoORM\Model\Magento20\CatalogAttribute;
use Kiboko\Component\MagentoORM\Model\Magento20\CatalogAttributeExtension;
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
                isset($options['attribute_id']) ? $options['attribute_id'] : null,
                isset($options['entity_type_id']) ? $options['entity_type_id'] : null,
                isset($options['attribute_code']) ? $options['attribute_code'] : null,
                isset($options['attribute_model']) ? $options['attribute_model'] : null,
                isset($options['backend_type']) ? $options['backend_type'] : null,
                isset($options['backend_model']) ? $options['backend_model'] : null,
                isset($options['backend_table']) ? $options['backend_table'] : null,
                isset($options['frontend_model']) ? $options['frontend_model'] : null,
                isset($options['frontend_input']) ? $options['frontend_input'] : null,
                isset($options['frontend_label']) ? $options['frontend_label'] : null,
                isset($options['frontend_class']) ? $options['frontend_class'] : null,
                isset($options['source_model']) ? $options['source_model'] : null,
                isset($options['is_required']) ? (bool) $options['is_required'] : false,
                isset($options['is_user_defined']) ? (bool) $options['is_user_defined'] : false,
                isset($options['is_unique']) ? (bool) $options['is_unique'] : false,
                isset($options['default_value']) ? $options['default_value'] : null
            ),
            new CatalogAttributeExtension(
                isset($options['attribute_id']) ? $options['attribute_id'] : null,
                isset($options['frontend_input_renderer']) ? $options['frontend_input_renderer'] : null,
                isset($options['is_global']) ? (bool) $options['is_global'] : 1,
                isset($options['is_visible']) ? (bool) $options['is_visible'] : false,
                isset($options['is_searchable']) ? (bool) $options['is_searchable'] : false,
                isset($options['is_filterable']) ? (bool) $options['is_filterable'] : false,
                isset($options['is_comparable']) ? (bool) $options['is_comparable'] : false,
                isset($options['is_visible_on_front']) ? (bool) $options['is_visible_on_front'] : false,
                isset($options['is_html_allowed_on_front']) ? (bool) $options['is_html_allowed_on_front'] : false,
                isset($options['is_used_for_price_rules']) ? (bool) $options['is_used_for_price_rules'] : false,
                isset($options['is_filterable_in_search']) ? (bool) $options['is_filterable_in_search'] : false,
                isset($options['used_in_product_listing']) ? (bool) $options['used_in_product_listing'] : false,
                isset($options['used_for_sort_by']) ? (bool) $options['used_for_sort_by'] : false,
                isset($options['is_visible_in_advanced_search']) ? (bool) $options['is_visible_in_advanced_search'] : false,
                isset($options['is_wysiwyg_enabled']) ? (bool) $options['is_wysiwyg_enabled'] : false,
                isset($options['is_used_for_promo_rules']) ? (bool) $options['is_used_for_promo_rules'] : false,
                isset($options['is_required_in_admin_store']) ? (bool) $options['is_required_in_admin_store'] : false,
                isset($options['is_used_in_grid']) ? (bool) $options['is_used_in_grid'] : false,
                isset($options['is_visible_in_grid']) ? (bool) $options['is_visible_in_grid'] : false,
                isset($options['is_filterable_in_grid']) ? (bool) $options['is_filterable_in_grid'] : false,
                isset($options['search_weight']) ? (bool) $options['search_weight'] : 0,
                isset($options['additional_data']) ? unserialize($options['additional_data']) : [],
                isset($options['apply_to']) ? explode(',', $options['apply_to']) : [],
                isset($options['note']) ? (string) $options['note'] : null,
                isset($options['position']) ? (bool) $options['position'] : 1
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
     * @param int $identifier
     *
     * @return CatalogAttributeExtensionInterface
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
     * @return \Traversable|CatalogAttributeExtensionInterface[]
     */
    public function findAllByCode($entityTypeCode, array $codeList)
    {
        $query = $this->queryBuilder->createFindAllByCodeQueryBuilder('a', 'x', 'e', $codeList);

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
     * @return \Traversable|CatalogAttributeExtensionInterface[]
     */
    public function findAllById(array $idList)
    {
        $query = $this->queryBuilder->createFindAllByIdQueryBuilder('a', 'x', $idList);

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
     * @return \Traversable|CatalogAttributeExtensionInterface[]
     */
    public function findAll()
    {
        $query = $this->queryBuilder->createFindAllQueryBuilder('a', 'x');

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
     * @return \Traversable|CatalogAttributeExtensionInterface[]
     */
    public function findAllByEntity(ProductInterface $product)
    {
        return $this->findAllByFamily($product->getFamily());
    }

    /**
     * @param string $entityTypeCode
     *
     * @return \Traversable|CatalogAttributeExtensionInterface[]
     */
    public function findAllByEntityTypeCode($entityTypeCode)
    {
        $query = $this->queryBuilder->createFindAllByEntityTypeQueryBuilder('a', 'x', 'e');

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
     * @return \Traversable|CatalogAttributeExtensionInterface[]
     */
    public function findAllByEntityTypeId($entityTypeId)
    {
        $query = $this->queryBuilder->createFindAllQueryBuilder('a', 'x');

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
     * @return \Traversable|CatalogAttributeExtensionInterface[]
     */
    public function findAllVariantAxisByEntity(ProductInterface $product)
    {
        if (!$product->isConfigurable()) {
            return;
        }

        $query = $this->queryBuilder->createFindAllVariantAxisByEntityQueryBuilder('a', 'x', 'e', 'va');

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
     * @return \Traversable|CatalogAttributeExtensionInterface[]
     */
    public function findAllByFamily(FamilyInterface $family)
    {
        $query = $this->queryBuilder->createFindAllByFamilyQueryBuilder('a', 'x', 'e', 'f');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$family->getId()])) {
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
     * @return \Traversable|CatalogAttributeExtensionInterface[]
     */
    public function findAllMandatoryByFamily(FamilyInterface $family)
    {
        $query = $this->queryBuilder->createFindAllMandatoryByFamilyQueryBuilder('a', 'x', 'e', 'f');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$family->getId()])) {
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
