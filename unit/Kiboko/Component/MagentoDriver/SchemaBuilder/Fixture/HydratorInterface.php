<?php

namespace unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture;


interface HydratorInterface
{
    /**
     * @param string $table
     * @param string $suite
     * @param string $context
     *
     * @return $this
     */
    public function hydrate($table, $suite, $context);
}