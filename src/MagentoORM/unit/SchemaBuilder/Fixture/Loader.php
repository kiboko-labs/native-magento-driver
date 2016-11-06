<?php

namespace unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture;

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
     * @param string $file
     * @return string
     */
    protected function getPathname($suite, $context, $file)
    {
        return $this->fallbackResolver->find($file, $suite, $context,
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
            $this->getPathname($suite, $context, 'expected'));
    }

    /**
     *
     * @param string $suite
     * @param string $context
     *
     * @return \PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function initialDataSet($suite, $context)
    {
        return new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            $this->getPathname($suite, $context, 'initial'));
    }

    /**
     *
     * @param string $name
     * @param string $suite
     * @param string $context
     *
     * @return \PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function namedDataSet($name, $suite, $context)
    {
        return new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            $this->getPathname($suite, $context, $name));
    }
}
