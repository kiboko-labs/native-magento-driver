<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

trait LocalizedMappableTrait
{
    use MappableTrait;

    private $mappingLocale;

    /**
     * @param string $locale
     */
    public function setMappingLocale($locale)
    {
        $this->mappingLocale = $locale;
    }

    /**
     * @return string
     */
    public function getMappingLocale()
    {
        return $this->mappingLocale;
    }
}
