<?php

namespace unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture;

class DeleterLoader extends Loader
{
    /**
     * @param string $magentoVersion
     * @param string $magentoEdition
     *
     * @return string
     */
    protected function getPathname($magentoVersion, $magentoEdition)
    {
        $file = sprintf('%s/deleter/initial.yml', $this->tableName);

        return $this->fixturesFallback($file, $magentoVersion, $magentoEdition);
    }
}
