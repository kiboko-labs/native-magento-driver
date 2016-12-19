<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\FieldConverter;

use Kiboko\Component\MagentoORM\Model\AttributeValueInterface;
use Pim\Component\Catalog\Model\ProductValueInterface;

interface FieldConverterInterface
{
    /**
     * @param ProductValueInterface $original
     *
     * @return AttributeValueInterface
     */
    public function export(ProductValueInterface $original);

    /**
     * @param AttributeValueInterface $original
     *
     * @return ProductValueInterface
     */
    public function import(AttributeValueInterface $original);
}
