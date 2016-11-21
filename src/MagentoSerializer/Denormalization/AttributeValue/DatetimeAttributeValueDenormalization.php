<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoSerializer\Denormalization\AttributeValue;

use Kiboko\Component\MagentoORM\Model\AttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\Immutable\ImmutableDatetimeAttributeValue;
use Kiboko\Component\MagentoORM\Repository\AttributeRepositoryInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class DatetimeAttributeValueDenormalization implements DenormalizerInterface
{
    /**
     * @var AttributeRepositoryInterface
     */
    protected $attributeRepository;

    /**
     * @param AttributeRepositoryInterface $attributeRepository
     */
    public function __construct(
        AttributeRepositoryInterface $attributeRepository
    ) {
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * @param mixed  $data
     * @param string $class
     * @param null   $format
     * @param array  $context
     *
     * @return AttributeValueInterface
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return new ImmutableDatetimeAttributeValue(
            $this->attributeRepository->findOneByCode('catalog_product', $data['attribute']),
            new \DateTimeImmutable($data['value']),
            null,
            isset($data['channel']) || isset($data['locale']) ? 0 : null
        );
    }

    /**
     * @param mixed  $data
     * @param string $type
     * @param null   $format
     *
     * @return bool
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return isset($data['attribute']) && isset($data['value']);
    }
}
