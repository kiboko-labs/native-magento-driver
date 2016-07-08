<?php

namespace unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture;

class FallbackResolver
{
    /**
     * @var string
     */
    private $basePath;

    /**
     * @var string
     */
    private $suite;

    /**
     * Magento EE and CE version equivalents
     *
     * @var array
     */
    private static $magentoVersionMapping = [
        '1.6'  => '1.4',
        '1.7'  => '1.4',
        '1.8'  => '1.4',
        '1.9'  => '1.5',
        '1.10' => '1.5',
        '1.11' => '1.6',
        '1.12' => '1.7',
        '1.13' => '1.8',
        '1.14' => '1.9',
    ];

    /**
     * FallbackResolver constructor.
     *
     * @param string $basePath
     * @param string $suite
     */
    public function __construct($basePath, $suite)
    {
        $this->basePath = $basePath;
        $this->suite = $suite;
    }

    /**
     * @param string $filename
     * @param string $suite
     * @param string $context
     * @param string $magentoVersion
     * @param string $magentoEdition
     * @return string
     */
    private function fixturesFile($filename, $suite, $context, $magentoVersion, $magentoEdition)
    {
        return strtr(
            '%basePath%/fixture/data-%edition%-%version%/%suite%/%context%/%file%.yml',
            [
                '%basePath%' => $this->basePath,
                '%edition%'  => strtolower($magentoEdition),
                '%version%'  => $magentoVersion,
                '%suite%'    => $suite,
                '%context%'  => $context,
                '%file%'     => $filename,
            ]
        );
    }

    /**
     * @param string $filename
     * @param string $suite
     * @param string $context
     * @param string $magentoVersion
     * @param string $magentoEdition
     * @return string
     */
    public function find($filename, $suite, $context, $magentoVersion, $magentoEdition)
    {
        $path = $this->fixturesFile($filename, $suite, $context, $magentoVersion, $magentoEdition);
        if (file_exists($path)) {
            return $path;
        }

        if (strtolower($magentoEdition) !== 'ee' || !isset(static::$magentoVersionMapping[$magentoVersion])) {
            throw new \PHPUnit_Framework_ExpectationFailedException(
                sprintf(
                    'Missing [%s:%s] fixtures for Magento %s %s',
                    $suite,
                    $context,
                    $magentoVersion,
                    strtoupper($magentoEdition)
                )
            );
        }

        $path = $this->fixturesFile($filename, $suite, $context, static::$magentoVersionMapping[$magentoVersion], 'ce');
        if (file_exists($path)) {
            return $path;
        }

        throw new \PHPUnit_Framework_ExpectationFailedException(
            sprintf(
                'Missing [%s:%s] fixtures for Magento %s %s',
                $suite,
                $context,
                $magentoVersion,
                strtoupper($magentoEdition)
            )
        );
    }
}