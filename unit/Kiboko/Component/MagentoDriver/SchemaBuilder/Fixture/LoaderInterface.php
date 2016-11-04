<?php

namespace unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture;

interface LoaderInterface
{
    /**
     * @param string $suite
     * @param string $context
     * @return \PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function expectedDataSet($suite, $context);

    /**
     * @param string $suite
     * @param string $context
     * @return \PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function initialDataSet($suite, $context);

    /**
     * @param string $name
     * @param string $suite
     * @param string $context
     * @return \PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function namedDataSet($name, $suite, $context);
}
