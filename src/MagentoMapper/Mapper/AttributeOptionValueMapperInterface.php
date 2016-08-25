<?php

namespace Kiboko\Component\MagentoMapper\Mapper;

interface AttributeOptionValueMapperInterface
{
    /**
     * @param string $code
     *
     * @return int
     */
    public function map($code);

    /**
     * @param string $optionCode
     * @param string $locale
     * @param int $identifier
     */
    public function persist($optionCode, $locale, $identifier);
}
