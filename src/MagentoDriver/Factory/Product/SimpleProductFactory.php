<?php

namespace Luni\Component\MagentoDriver\Factory\Product;


use Luni\Component\MagentoDriver\Entity\Product\ProductInterface;
use Luni\Component\MagentoDriver\Entity\Product\SimpleProduct;
use Luni\Component\MagentoDriver\Factory\ProductFactoryInterface;
use Luni\Component\MagentoDriver\Repository\FamilyRepositoryInterface;

class SimpleProductFactory
    implements ProductFactoryInterface
{
    /**
     * @var FamilyRepositoryInterface
     */
    private $familyRepository;

    /**
     * SimpleProductFactory constructor.
     * @param FamilyRepositoryInterface $familyRepository
     */
    public function __construct(FamilyRepositoryInterface $familyRepository)
    {
        $this->familyRepository = $familyRepository;
    }

    /**
     * @param string $type
     * @param array $options
     * @return ProductInterface
     */
    public function buildNew($type, array $options)
    {
        return SimpleProduct::buildNewWith(
            $options['entity_id'],
            $options['sku'],
            $this->familyRepository->findOneById($options['attribute_set_id']),
            new \DateTimeImmutable($options['created_at']),
            new \DateTimeImmutable($options['updated_at'])
        );
    }
}