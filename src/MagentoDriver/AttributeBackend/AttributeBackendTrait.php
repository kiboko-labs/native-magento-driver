<?php

namespace Luni\Component\MagentoDriver\AttributeBackend;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Exception\RuntimeErrorException;
use Symfony\Component\Filesystem\Filesystem;

trait AttributeBackendTrait
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var Filesystem
     */
    protected $localFs;

    /**
     * @throws RuntimeErrorException
     */
    public function initialize()
    {
        $exportDirectory = dirname($this->getPath());
        if (!is_dir($exportDirectory)) {
            $this->localFs->mkdir($exportDirectory);
        }

        $this->localFs->touch($this->getPath());
        $this->localFs->chmod($this->getPath(), 0600);

        if (false === $this->tmpFile = fopen($this->getPath(), 'w')) {
            throw new RuntimeErrorException(sprintf('Failed to open file %s for writing', $this->getPath()));
        }
    }

    /**
     * Flushes data into the DB
     */
    abstract public function flush();
}