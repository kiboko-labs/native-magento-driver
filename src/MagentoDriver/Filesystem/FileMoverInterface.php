<?php

namespace Kiboko\Component\MagentoDriver\Filesystem;

use League\Flysystem\FilesystemInterface;

interface FileMoverInterface
{
    public function move(
        FilesystemInterface $source,
        FilesystemInterface $destination,
        \Traversable $pathList
    );
}
