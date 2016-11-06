<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory\Product;

use Kiboko\Component\MagentoORM\Entity\Product\ConfigurableProduct;
use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoORM\Factory\ProductFactoryInterface;
use Kiboko\Component\MagentoORM\Repository\FamilyRepositoryInterface;

class ConfigurableProductFactory
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
        return ConfigurableProduct::buildNewWith(
            $options['entity_id'],
            $options['sku'],
            $this->familyRepository->findOneById($options['attribute_set_id']),
            new \DateTimeImmutable($options['created_at']),
            new \DateTimeImmutable($options['updated_at'])
        );
    }
}
