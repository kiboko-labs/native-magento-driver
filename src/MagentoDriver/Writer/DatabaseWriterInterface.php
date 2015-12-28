<?php

namespace Luni\Component\MagentoDriver\Writer;

use League\Flysystem\File;

interface DatabaseWriterInterface
{
    /**
     * @param File $filename
     * @param string $table
     * @param string[]|array $tableFields
     * @return void
     */
    public function writeFromFile(File $filename, $table, array $tableFields);

    /**
     * @param File $filename
     * @param string $table
     * @param string[]|array $tableFields
     * @return void
     */
    public function writeFromLocalFile(File $filename, $table, array $tableFields);
}