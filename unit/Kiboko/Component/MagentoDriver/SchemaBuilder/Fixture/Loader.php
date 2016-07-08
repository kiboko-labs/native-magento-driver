<?php

namespace unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture;

use Doctrine\DBAL\Connection;
use Symfony\Component\Yaml\Yaml;

class Loader implements LoaderInterface
{
    /**
     * @var string
     */
    private $magentoVersion;

    /**
     * @var string
     */
    private $magentoEdition;

    /**
     * @var FallbackResolver
     */
    private $fallbackResolver;

    /**
     * @param FallbackResolver $resolver
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function __construct(
        FallbackResolver $resolver,
        $magentoVersion,
        $magentoEdition
    ) {
        $this->fallbackResolver = $resolver;
        $this->magentoVersion = $magentoVersion;
        $this->magentoEdition = $magentoEdition;
    }

    /**
     * @param string $suite
     * @param string $context
     * @return string
     */
    protected function getPathname($suite, $context)
    {
        return $this->fallbackResolver->find('initial', $suite, $context,
            $this->magentoVersion, $this->magentoEdition);
    }

    /**
     *
     * @param string $suite
     * @param string $context
     *
     * @return \PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function expectedDataSet($suite, $context)
    {
        return new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            $this->getPathname($suite, $context));
    }
}
