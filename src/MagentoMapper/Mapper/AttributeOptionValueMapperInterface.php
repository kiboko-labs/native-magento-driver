<?php

namespace Kiboko\Component\MagentoMapper\Mapper;

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
     * @param int $identifier
     */
    public function persist($optionCode, $locale, $identifier);

    /**
     * @return void
     */
    public function flush();
}
