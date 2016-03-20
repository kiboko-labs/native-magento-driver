<?php

namespace Luni\Component\MagentoMapper\Mapper;

use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\OptionInterface;
use Luni\Component\MagentoDriver\Repository\OptionRepositoryInterface;

class DefaultOptionMapper
    implements OptionMapperInterface
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
     * @return int
     */
    public function map($identifier)
    {
        if (!isset($this->mapping[$identifier])) {
            return null;
        }

        return $this->mapping[$identifier];
    }
}