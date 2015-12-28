<?php

namespace Luni\Component\MagentoDriver\Writer\Temporary;

use League\Flysystem\File;

interface TemporaryWriterInterface
{
    /**
     * @param array $row
     */
    public function persistRow(array $row);
}