<?php

namespace Kiboko\Component\MagentoDriver\Factory\Product;

use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Entity\Product\SimpleProduct;
use Kiboko\Component\MagentoDriver\Factory\ProductFactoryInterface;
use Kiboko\Component\MagentoDriver\Repository\FamilyRepositoryInterface;

class SimpleProductFactory
    implements ProductFactoryInterface
{
    /**
     * @var FamilyRepositoryInterface
     */
    private $familyRepository;

    /**
     * SimpleProductFactory constructor.
     *
     * @param FamilyRepositoryInterface $familyRepository
     */
    public function __construct(FamilyRepositoryInterface $familyRepository)
    {
        $this->familyRepository = $familyRepository;
    }

    /**
     * @param array  $options
     *
     * @return ProductInterface
     */
    public function buildNew(array $options)
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
