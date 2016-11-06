<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Mapper;

interface AttributeOptionValueMapperInterface
{
    /**
     * @param string $code
     * @param string $locale
     *
     * @return int
     */
    public function map($code, $locale);

    /**
     * @param string $optionCode
     * @param string $locale
     * @param int    $identifier
     */
    public function persist($optionCode, $locale, $identifier);

    public function flush();
}
