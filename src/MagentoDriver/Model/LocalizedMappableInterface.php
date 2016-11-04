<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model;

interface LocalizedMappableInterface extends MappableInterface
{
    /**
     * @param string $locale
     */
    public function setMappingLocale($locale);

    /**
     * @return string
     */
    public function getMappingLocale();
}
