<?php

namespace Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine;

class ProductMediaGalleryAttributeValueQueryBuilder implements ProductMediaGalleryAttributeValueQueryBuilderInterface
{
    /**
     * @param null $prefix
     *
     * @return string
     */
    public static function getDefaultImageTable($prefix = null)
    {
        if ($prefix !== null) {
            return sprintf('%scatalog_product_entity_media_gallery', $prefix);
        }

        return 'catalog_product_entity_media_gallery';
    }

    /**
     * @param null $prefix
     *
     * @return string
     */
    public static function getDefaultLocaleTable($prefix = null)
    {
        if ($prefix !== null) {
            return sprintf('%scatalog_product_entity_media_gallery_value', $prefix);
        }

        return 'catalog_product_entity_media_gallery_value';
    }
}
