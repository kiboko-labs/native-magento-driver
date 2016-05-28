<?php

namespace Kiboko\Component\MagentoMapper\Mapper;

use Doctrine\Common\Collections\Collection;
use Kiboko\Component\MagentoDriver\Model\OptionInterface;

class DefaultOptionMapper implements OptionMapperInterface
{
    /**
     * @var Collection|OptionInterface[]
     */
    private $mapping;

    /**
     * @param array $mapping
     */
    public function __construct(
        array $mapping
    ) {
        $this->mappig = $mapping;
    }

    /**
     * @param string $identifier
     *
     * @return int
     */
    public function map($identifier)
    {
        if (!isset($this->mapping[$identifier])) {
            return;
        }

        return $this->mapping[$identifier];
    }
}
