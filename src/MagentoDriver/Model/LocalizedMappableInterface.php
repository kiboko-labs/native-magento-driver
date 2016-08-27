<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface LocalizedMappableInterface extends MappableInterface
{
    /**
     * @param string $locale
     */
    public function setMappingLocale($code, $locale);

    /**
     * @return string
     */
    public function getMappingLocale();
}
