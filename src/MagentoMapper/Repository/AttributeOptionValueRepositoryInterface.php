<?php

namespace Kiboko\Component\MagentoMapper\Repository;

interface AttributeOptionValueRepositoryInterface
{
    /**
     * @param string $code
     * @param string $locale
     *
     * @return int
     */
    public function findOneByCodeAndLocale($code, $locale);

    /**
     * @return int[]
     */
    public function findAll();
}
