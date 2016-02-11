<?php

namespace Luni\Component\MagentoDriver\Denormalization;

use Luni\Component\MagentoDriver\Denormalization\AttributeValue\DatetimeAttributeValueDenormalization;
use Luni\Component\MagentoDriver\Denormalization\AttributeValue\DecimalAttributeValueDenormalization;
use Luni\Component\MagentoDriver\Denormalization\AttributeValue\IntegerAttributeValueDenormalization;
use Luni\Component\MagentoDriver\Denormalization\AttributeValue\MultipleOptionsAttributeValueDenormalization;
use Luni\Component\MagentoDriver\Denormalization\AttributeValue\OptionAttributeValueDenormalization;
use Luni\Component\MagentoDriver\Denormalization\AttributeValue\TextAttributeValueDenormalization;
use Luni\Component\MagentoDriver\Denormalization\AttributeValue\VarcharAttributeValueDenormalization;
use Luni\Component\MagentoDriver\Entity\Product\SimpleProduct;
use Luni\Component\MagentoDriver\Entity\ProductInterface;
use Luni\Component\MagentoDriver\Exception\RuntimeErrorException;
use Luni\Component\MagentoDriver\Factory\ProductAttributeValueFactoryInterface;
use Luni\Component\MagentoDriver\Factory\ProductFactoryInterface;
use Luni\Component\MagentoDriver\Mapper\DefaultOptionMapper;
use Luni\Component\MagentoDriver\Mapper\FamilyMapperInterface;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Repository\AttributeRepositoryInterface;
use Luni\Component\MagentoDriver\Repository\FamilyRepositoryInterface;
use Luni\Component\MagentoMapper\Repository\OptionRepositoryInterface as OptionMappingRepositoryInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class SimpleProductDenormalization
    implements DenormalizerInterface
{
    /**
     * @var FamilyMapperInterface
     */
    private $familyMapper;

    /**
     * @var FamilyRepositoryInterface
     */
    private $familyRepository;

    /**
     * @var AttributeRepositoryInterface
     */
    private $attributeRepository;

    /**
     * @var ProductFactoryInterface
     */
    private $productFactory;

    /**
     * @var ProductAttributeValueFactoryInterface
     */
    private $valueFactory;

    /**
     * @var \SplObjectStorage
     */
    private $attributeDenormalizers;

    /**
     * ProductDenormalization constructor.
     *
     * @param FamilyMapperInterface $familyMapper
     * @param FamilyRepositoryInterface $familyRepository
     * @param AttributeRepositoryInterface $attributeRepository
     * @param OptionMappingRepositoryInterface $optionMappingRepository
     * @param ProductFactoryInterface $productFactory
     * @param ProductAttributeValueFactoryInterface $valueFactory
     */
    public function __construct(
        FamilyMapperInterface $familyMapper,
        FamilyRepositoryInterface $familyRepository,
        AttributeRepositoryInterface $attributeRepository,
        OptionMappingRepositoryInterface $optionMappingRepository,
        ProductFactoryInterface $productFactory,
        ProductAttributeValueFactoryInterface $valueFactory
    ) {
        $this->familyMapper = $familyMapper;
        $this->familyRepository = $familyRepository;
        $this->attributeRepository = $attributeRepository;
        $this->optionMappingRepository = $optionMappingRepository;
        $this->productFactory = $productFactory;
        $this->valueFactory = $valueFactory;

        $this->attributeDenormalizers = new \SplObjectStorage();
    }

    private function selectAttributeDenormalizer(AttributeInterface $attribute)
    {
        if ($this->attributeDenormalizers->contains($attribute)) {
            return $this->attributeDenormalizers->offsetGet($attribute);
        }

        if ($attribute->getBackendType() === 'decimal') {
            if ($attribute->getFrontendType() === 'price') {
                $denormalizer = new DecimalAttributeValueDenormalization(
                    $this->attributeRepository
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);
                return $denormalizer;
            } else if ($attribute->getFrontendType() === 'weight') {
                $denormalizer = new DecimalAttributeValueDenormalization(
                    $this->attributeRepository
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);
                return $denormalizer;
            } else if ($attribute->getFrontendType() === 'text') {
                $denormalizer = new DecimalAttributeValueDenormalization(
                    $this->attributeRepository
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);
                return $denormalizer;
            } else {
                throw new RuntimeErrorException('Unexpected attribute type.');
            }
        } else if ($attribute->getBackendType() === 'datetime') {
            if ($attribute->getFrontendType() === 'date') {
                $denormalizer = new DatetimeAttributeValueDenormalization(
                    $this->attributeRepository
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);
                return $denormalizer;
            } else {
                throw new RuntimeErrorException('Unexpected attribute type.');
            }
        } else if ($attribute->getBackendType() === 'int') {
            if ($attribute->getFrontendType() === null) {
                $denormalizer = new IntegerAttributeValueDenormalization(
                    $this->attributeRepository
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);
                return $denormalizer;
            } else if ($attribute->getFrontendType() === 'text') {
                $denormalizer = new IntegerAttributeValueDenormalization(
                    $this->attributeRepository
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);
                return $denormalizer;
            } else if ($attribute->getFrontendType() === 'select') {
                $denormalizer = new OptionAttributeValueDenormalization(
                    $this->attributeRepository,
                    new DefaultOptionMapper(
                        $this->optionMappingRepository->findAllByAttribute($attribute)
                    )
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);
                return $denormalizer;
            } else {
                throw new RuntimeErrorException('Unexpected attribute type.');
            }
        } else if ($attribute->getBackendType() === 'text') {
            if ($attribute->getFrontendType() === 'textarea') {
                $denormalizer = new TextAttributeValueDenormalization(
                    $this->attributeRepository
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);
                return $denormalizer;
            } else if ($attribute->getFrontendType() === 'text') {
                $denormalizer = new TextAttributeValueDenormalization(
                    $this->attributeRepository
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);
                return $denormalizer;
            } else if ($attribute->getFrontendType() === 'multiselect') {
                $denormalizer = new MultipleOptionsAttributeValueDenormalization(
                    $this->attributeRepository,
                    new DefaultOptionMapper(
                        $this->optionMappingRepository->findAllByAttribute($attribute)
                    )
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);
                return $denormalizer;
            } else if ($attribute->getFrontendType() === 'select') {
                $denormalizer = new OptionAttributeValueDenormalization(
                    $this->attributeRepository,
                    new DefaultOptionMapper(
                        $this->optionMappingRepository->findAllByAttribute($attribute)
                    )
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);
                return $denormalizer;
            } else {
                throw new RuntimeErrorException('Unexpected attribute type.');
            }
        } else if ($attribute->getBackendType() === 'varchar') {
            if ($attribute->getFrontendType() === null) {
                $denormalizer = new VarcharAttributeValueDenormalization(
                    $this->attributeRepository
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);
                return $denormalizer;
            } else if ($attribute->getFrontendType() === 'textarea') {
                $denormalizer = new VarcharAttributeValueDenormalization(
                    $this->attributeRepository
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);
                return $denormalizer;
            } else if ($attribute->getFrontendType() === 'text') {
                $denormalizer = new VarcharAttributeValueDenormalization(
                    $this->attributeRepository
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);
                return $denormalizer;
            } else if ($attribute->getFrontendType() === 'multiselect') {
                $denormalizer = new MultipleOptionsAttributeValueDenormalization(
                    $this->attributeRepository,
                    new DefaultOptionMapper(
                        $this->optionMappingRepository->findAllByAttribute($attribute)
                    )
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);
                return $denormalizer;
            } else if ($attribute->getFrontendType() === 'select') {
                $denormalizer = new OptionAttributeValueDenormalization(
                    $this->attributeRepository,
                    new DefaultOptionMapper(
                        $this->optionMappingRepository->findAllByAttribute($attribute)
                    )
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);
                return $denormalizer;
            } else if ($attribute->getFrontendType() === 'media_image') {
                // TODO: add support for media attributes
            } else if ($attribute->getFrontendType() === 'gallery') {
                // TODO: add support for media attributes
            } else {
                throw new RuntimeErrorException('Unexpected attribute type.');
            }
        }

        throw new RuntimeErrorException('Unexpected attribute type.');
    }

    /**
     * @param mixed $data
     * @param string $class
     * @param null $format
     * @param array $context
     * @return ProductInterface
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $familyId = $this->familyMapper->map($data['family']);

        $product = new SimpleProduct(
            $data['sku'],
            $this->familyRepository->findOneById($familyId)
        );

        if (!empty($data['groups'])) {
            $product->setNotVisible();
        } else {
            $product->setVisibleInCatalogAndSearch();
        }

        unset(
            $data['sku'],
            $data['family'],
            $data['excluded'],
            $data['groups'],
            $data['categories'],
            $data['enabled']
        );

        foreach ($data as $field) {
            foreach ($field as $value) {
                $attribute = $this->attributeRepository->findOneByCode('catalog_product', $value['attribute']);

                if ($attribute === null) {
                    continue;
                }

                $product->setValue($this->selectAttributeDenormalizer($attribute)
                    ->denormalize($value, AttributeValueInterface::class));
            }
        }

        return $product;
    }

    /**
     * @param mixed $data
     * @param string $type
     * @param null $format
     * @return bool
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return true;
    }
}