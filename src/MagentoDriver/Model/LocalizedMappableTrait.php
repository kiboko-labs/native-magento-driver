<?php

namespace Kiboko\Component\MagentoDriver\Model;

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
