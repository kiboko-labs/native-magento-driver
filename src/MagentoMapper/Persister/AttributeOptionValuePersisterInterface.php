<?php

namespace Kiboko\Component\MagentoMapper\Persister;

interface AttributeOptionValuePersisterInterface
{
    /**
     * @param string $optionsCode
     * @param string $locale
     * @param int $identifier
     */
    public function persist($optionsCode, $locale, $identifier);
}
