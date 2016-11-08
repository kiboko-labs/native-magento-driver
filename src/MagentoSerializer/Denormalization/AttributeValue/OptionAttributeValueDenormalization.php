<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoSerializer\Denormalization\AttributeValue;

use Kiboko\Component\AkeneoToMagentoMapper\Mapper\OptionMapperInterface;
use Kiboko\Component\MagentoORM\Model\AttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\Immutable\ImmutableIntegerAttributeValue;
use Kiboko\Component\MagentoORM\Model\Immutable\ImmutableVarcharAttributeValue;
use Kiboko\Component\MagentoORM\Repository\AttributeRepositoryInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class OptionAttributeValueDenormalization implements DenormalizerInterface
{
    /**
     * @var AttributeRepositoryInterface
     */
    protected $attributeRepository;

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
        $attribute = $this->attributeRepository->findOneByCode('catalog_product', $data['attribute']);

        if (!$attribute) {
            return;
        }

        if ($attribute->getBackendType() === 'int') {
            return new ImmutableIntegerAttributeValue(
                $attribute,
                (int) $data['value'],
                null,
                isset($data['channel']) || isset($data['locale']) ? 0 : null
            );
        } elseif ($attribute->getBackendType() === 'varchar') {
            return new ImmutableVarcharAttributeValue(
                $attribute,
                $data['value'],
                null,
                isset($data['channel']) || isset($data['locale']) ? 0 : null
            );
        }

        return;
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
