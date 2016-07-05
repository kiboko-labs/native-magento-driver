<?php

namespace unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture;

interface LoaderInterface
{
    /**
     * @return \PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function loadFixtures();

    /**
     * @return \PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function expectedDataSet();
}