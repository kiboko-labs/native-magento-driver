<?php

namespace Luni\Component\MagentoDriver\Writer\Temporary;

use League\Flysystem\File;
use Luni\Component\MagentoDriver\Exception\RuntimeErrorException;

class StandardTemporaryWriter
    implements TemporaryWriterInterface
{
    /**
     * @var File
     */
    private $file;

    /**
     * @var string
     */
    private $delimiter;

    /**
     * @var string
     */
    private $enclosure;

    /**
     * @var string
     */
    private $escaper;

    /**
     * @var resource
     */
    private $stream;

    /**
     * DataInfileDatabaseWriter constructor.
     * @param File $file
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escaper
     */
    public function __construct(
        File $file,
        $delimiter,
        $enclosure,
        $escaper
    ) {
        $this->file = $file;
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
        $this->escaper = $escaper;

        if (false === ($this->stream = fopen('php://temp', 'w'))) {
            throw new RuntimeErrorException('Failed to open temporary stream.');
        }
    }

    /**
     * @param array $row
     */
    public function persistRow(array $row)
    {
        if (false === fputcsv($this->stream, $row, $this->delimiter, $this->enclosure)) {
            throw new RuntimeErrorException('Failed to serialize to CSV.');
        }
    }

    /**
     *
     */
    public function flush()
    {
        $this->file->putStream($this->stream);
        ftruncate($this->stream, 0);
    }
}