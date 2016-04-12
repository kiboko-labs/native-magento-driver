<?php

namespace Luni\Component\MagentoSerializer\Denormalization\AttributeValue;

use Luni\Component\MagentoMapper\Mapper\OptionMapperInterface;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Model\Immutable\ImmutableVarcharAttributeValue;
use Luni\Component\MagentoDriver\Repository\AttributeRepositoryInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class MultipleOptionsAttributeValueDenormalization implements DenormalizerInterface
{
    /**
     * @var AttributeRepositoryInterface
     */
    private $attributeRepository;

    /**
     * @var OptionMapperInterface
     */
    private $optionsMapper;

    /**
     * @param AttributeRepositoryInterface $attributeRepository
     * @param OptionMapperInterface        $optionsMapper
     */
    public function __construct(
        AttributeRepositoryInterface $attributeRepository,
        OptionMapperInterface $optionsMapper
    ) {
        $this->attributeRepository = $attributeRepository;
        $this->optionsMapper = $optionsMapper;
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
        return new ImmutableVarcharAttributeValue(
            $this->attributeRepository->findOneByCode('catalog_product', $data['attribute']),
            implode(',', $data['value']),
            null,
            isset($data['channel']) || isset($data['locale']) ? 1 : null
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
