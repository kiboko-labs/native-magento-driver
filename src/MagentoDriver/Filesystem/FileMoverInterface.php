<?php

namespace Kiboko\Component\MagentoDriver\Filesystem;

use Doctrine\Common\Collections\Collection;
use League\Flysystem\FilesystemInterface;

interface FileMoverInterface
{
    public function move(
        FilesystemInterface $source,
        FilesystemInterface $destination,
        Collection $pathList
    );
}
