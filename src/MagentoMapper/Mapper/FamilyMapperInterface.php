<?php

namespace Kiboko\Component\MagentoMapper\Mapper;

interface FamilyMapperInterface
{
    /**
     * @param string $code
     *
     * @return int
     */
    public function map($code);

    /**
     * @param string $code
     * @param int $identifier
     */
    public function persist($code, $identifier);

    /**
     * @return void
     */
    public function flush();
}
