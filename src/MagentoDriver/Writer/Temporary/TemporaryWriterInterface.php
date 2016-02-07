<?php

namespace Luni\Component\MagentoDriver\Writer\Temporary;

interface TemporaryWriterInterface
{
    /**
     * @param array $row
     */
    public function persistRow(array $row);

    /**
     *
     */
    public function flush();
}