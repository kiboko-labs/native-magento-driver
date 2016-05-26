<?php

namespace Kiboko\Bundle\MagentoDriverBundle\DependencyInjection;

use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\EntityAttributeQueryBuilder;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilder;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\AttributeGroupQueryBuilder;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\AttributeLabelQueryBuilder;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\AttributeOptionQueryBuilder;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\AttributeOptionValueQueryBuilder;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeValueQueryBuilder;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\EntityStoreQueryBuilder;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\FamilyQueryBuilder;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\EntityTypeQueryBuilder;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductQueryBuilder;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductSuperAttributeQueryBuilder;

class ParameterRegistry
{
    public function extend(array $parameters)
    {
        return array_merge(
            $parameters,
            $this->getEntityAttributeParameters(),
            $this->getEntityTypeParameters(),
            $this->getAttributeParameters(),
            $this->getCatalogAttributeParameters(),
            $this->getProductAttributeGroupParameters(),
            $this->getProductAttributeLabelParameters(),
            $this->getProductAttributeOptionParameters(),
            $this->getProductAttributeOptionValueParameters(),
            $this->getProductAttributeValueParameters(),
            $this->getProductEntityParameters(),
            $this->getEntityStoreParameters(),
            $this->getFamilyParameters(),
            $this->getSuperAttributeParameters()
        );
    }

    /**
     * @return array
     */
    private function getEntityAttributeParameters()
    {
        return [
            'kiboko.magento_driver.backend.entity_attribute.table'
                => EntityAttributeQueryBuilder::getDefaultTable() . '_copy',
            'kiboko.magento_driver.backend.entity_attribute.fields'
                => EntityAttributeQueryBuilder::getDefaultFields(),
        ];
    }

    /**
     * @return array
     */
    private function getEntityTypeParameters()
    {
        return [
            'kiboko.magento_driver.backend.entity_type.table'
                => EntityTypeQueryBuilder::getDefaultTable() . '_copy',
            'kiboko.magento_driver.backend.entity_type.fields'
                => EntityTypeQueryBuilder::getDefaultFields(),
        ];
    }

    /**
     * @return array
     */
    private function getAttributeParameters()
    {
        return [
            'kiboko.magento_driver.backend.attribute.standard.table'
                => ProductAttributeQueryBuilder::getDefaultTable() . '_copy',
            'kiboko.magento_driver.backend.attribute.standard.fields'
                => ProductAttributeQueryBuilder::getDefaultFields(),
        ];
    }

    /**
     * @return array
     */
    private function getCatalogAttributeParameters()
    {
        return [
            'kiboko.magento_driver.backend.attribute.catalog_extras.table'
                => ProductAttributeQueryBuilder::getDefaultExtraTable() . '_copy',
            'kiboko.magento_driver.backend.attribute.catalog_entity.table'
                => ProductAttributeQueryBuilder::getDefaultEntityTable() . '_copy',
            'kiboko.magento_driver.backend.attribute.variant_axis.table'
                => ProductAttributeQueryBuilder::getDefaultVariantTable() . '_copy',
            'kiboko.magento_driver.backend.attribute.family.table'
                => ProductAttributeQueryBuilder::getDefaultFamilyTable() . '_copy',
            'kiboko.magento_driver.backend.attribute.catalog_extras.fields'
                => ProductAttributeQueryBuilder::getDefaultExtraFields(),
        ];
    }

    /**
     * @return array
     */
    private function getProductAttributeGroupParameters()
    {
        return [
            'kiboko.magento_driver.backend.attribute.group.table'
                => AttributeGroupQueryBuilder::getDefaultTable() . '_copy',
            'kiboko.magento_driver.backend.attribute.group.fields'
                => AttributeGroupQueryBuilder::getDefaultFields(),
        ];
    }

    /**
     * @return array
     */
    private function getProductAttributeLabelParameters()
    {
        return [
            'kiboko.magento_driver.backend.attribute.label.table'
                => AttributeLabelQueryBuilder::getDefaultTable() . '_copy',
            'kiboko.magento_driver.backend.attribute.label.fields'
                => AttributeLabelQueryBuilder::getDefaultFields(),
        ];
    }

    /**
     * @return array
     */
    private function getProductAttributeOptionParameters()
    {
        return [
            'kiboko.magento_driver.backend.attribute.option.table'
                => AttributeOptionQueryBuilder::getDefaultTable() . '_copy',
            'kiboko.magento_driver.backend.attribute.option.fields'
                => AttributeOptionQueryBuilder::getDefaultFields(),
        ];
    }

    /**
     * @return array
     */
    private function getProductAttributeOptionValueParameters()
    {
        return [
            'kiboko.magento_driver.backend.attribute.option_value.table'
                => AttributeOptionValueQueryBuilder::getDefaultTable() . '_copy',
            'kiboko.magento_driver.backend.attribute.option_value.fields'
                => AttributeOptionValueQueryBuilder::getDefaultFields(),
        ];
    }

    /**
     * @return array
     */
    private function getProductAttributeValueParameters()
    {
        return [
            'kiboko.magento_driver.backend.product_attribute_value.datetime.table'
                => ProductAttributeValueQueryBuilder::getDefaultTable('datetime') . '_copy',
            'kiboko.magento_driver.backend.product_attribute_value.decimal.table'
                => ProductAttributeValueQueryBuilder::getDefaultTable('decimal') . '_copy',
            'kiboko.magento_driver.backend.product_attribute_value.integer.table'
                => ProductAttributeValueQueryBuilder::getDefaultTable('integer') . '_copy',
            'kiboko.magento_driver.backend.product_attribute_value.text.table'
                => ProductAttributeValueQueryBuilder::getDefaultTable('text') . '_copy',
            'kiboko.magento_driver.backend.product_attribute_value.varchar.table'
                => ProductAttributeValueQueryBuilder::getDefaultTable('varchar') . '_copy',
            'kiboko.magento_driver.backend.product_attribute_value.variant_axis.table'
                => ProductAttributeValueQueryBuilder::getDefaultVariantAxisTable() . '_copy',
            'kiboko.magento_driver.backend.product_attribute_value.fields'
                => ProductAttributeValueQueryBuilder::getDefaultFields(),
        ];
    }

    /**
     * @return array
     */
    private function getProductEntityParameters()
    {
        return [
            'kiboko.magento_driver.backend.product.table'
                => ProductQueryBuilder::getDefaultTable() . '_copy',
            'kiboko.magento_driver.backend.product.fields'
                => ProductQueryBuilder::getDefaultFields(),
            'kiboko.magento_driver.backend.category_product.table'
                => ProductQueryBuilder::getDefaultCategoryProductTable(),
        ];
    }

    /**
     * @return array
     */
    private function getEntityStoreParameters()
    {
        return [
            'kiboko.magento_driver.backend.entity_store.table'
                => EntityStoreQueryBuilder::getDefaultTable() . '_copy',
            'kiboko.magento_driver.backend.entity_store.fields'
                => EntityStoreQueryBuilder::getDefaultFields(),
        ];
    }

    /**
     * @return array
     */
    private function getFamilyParameters()
    {
        return [
            'kiboko.magento_driver.backend.family.table'
                => FamilyQueryBuilder::getDefaultTable() . '_copy',
            'kiboko.magento_driver.backend.family.fields'
                => FamilyQueryBuilder::getDefaultFields(),
        ];
    }

    /**
     * @return array
     */
    private function getSuperAttributeParameters()
    {
        return [
            'kiboko.magento_driver.backend.product_super_attribute.table'
                => ProductSuperAttributeQueryBuilder::getDefaultTable() . '_copy',
            'kiboko.magento_driver.backend.product_super_attribute.fields'
                => ProductSuperAttributeQueryBuilder::getDefaultFields(),
        ];
    }
}
