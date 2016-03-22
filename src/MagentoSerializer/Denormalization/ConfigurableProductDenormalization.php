<?php

namespace Luni\Component\MagentoSerializer\Denormalization;

use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Entity\Product\ConfigurableProductInterface;
use Luni\Component\MagentoDriver\Entity\Product\ProductInterface;
use Luni\Component\MagentoSerializer\Denormalization\AttributeValue\DummyAttributeValueDenormalization;
use Luni\Component\MagentoSerializer\Denormalization\AttributeValue\DatetimeAttributeValueDenormalization;
use Luni\Component\MagentoSerializer\Denormalization\AttributeValue\DecimalAttributeValueDenormalization;
use Luni\Component\MagentoSerializer\Denormalization\AttributeValue\IntegerAttributeValueDenormalization;
use Luni\Component\MagentoSerializer\Denormalization\AttributeValue\MultipleOptionsAttributeValueDenormalization;
use Luni\Component\MagentoSerializer\Denormalization\AttributeValue\OptionAttributeValueDenormalization;
use Luni\Component\MagentoSerializer\Denormalization\AttributeValue\TextAttributeValueDenormalization;
use Luni\Component\MagentoSerializer\Denormalization\AttributeValue\VarcharAttributeValueDenormalization;
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

class ConfigurableProductDenormalization implements DenormalizerInterface
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
     * @param FamilyMapperInterface                 $familyMapper
     * @param FamilyRepositoryInterface             $familyRepository
     * @param AttributeRepositoryInterface          $attributeRepository
     * @param OptionMappingRepositoryInterface      $optionMappingRepository
     * @param ProductFactoryInterface               $productFactory
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
            } elseif ($attribute->getFrontendType() === 'weight') {
                $denormalizer = new DecimalAttributeValueDenormalization(
                    $this->attributeRepository
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);

                return $denormalizer;
            } elseif ($attribute->getFrontendType() === 'text') {
                $denormalizer = new DecimalAttributeValueDenormalization(
                    $this->attributeRepository
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);

                return $denormalizer;
            } else {
                throw new RuntimeErrorException('Unexpected attribute type.');
            }
        } elseif ($attribute->getBackendType() === 'datetime') {
            if ($attribute->getFrontendType() === 'date') {
                $denormalizer = new DatetimeAttributeValueDenormalization(
                    $this->attributeRepository
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);

                return $denormalizer;
            } else {
                throw new RuntimeErrorException('Unexpected attribute type.');
            }
        } elseif ($attribute->getBackendType() === 'int') {
            if ($attribute->getFrontendType() === null) {
                $denormalizer = new IntegerAttributeValueDenormalization(
                    $this->attributeRepository
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);

                return $denormalizer;
            } elseif ($attribute->getFrontendType() === 'text') {
                $denormalizer = new IntegerAttributeValueDenormalization(
                    $this->attributeRepository
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);

                return $denormalizer;
            } elseif ($attribute->getFrontendType() === 'select') {
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
        } elseif ($attribute->getBackendType() === 'text') {
            if ($attribute->getFrontendType() === 'textarea') {
                $denormalizer = new TextAttributeValueDenormalization(
                    $this->attributeRepository
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);

                return $denormalizer;
            } elseif ($attribute->getFrontendType() === 'text') {
                $denormalizer = new TextAttributeValueDenormalization(
                    $this->attributeRepository
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);

                return $denormalizer;
            } elseif ($attribute->getFrontendType() === 'multiselect') {
                $denormalizer = new MultipleOptionsAttributeValueDenormalization(
                    $this->attributeRepository,
                    new DefaultOptionMapper(
                        $this->optionMappingRepository->findAllByAttribute($attribute)
                    )
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);

                return $denormalizer;
            } elseif ($attribute->getFrontendType() === 'select') {
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
        } elseif ($attribute->getBackendType() === 'varchar') {
            if ($attribute->getFrontendType() === null) {
                $denormalizer = new VarcharAttributeValueDenormalization(
                    $this->attributeRepository
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);

                return $denormalizer;
            } elseif ($attribute->getFrontendType() === 'textarea') {
                $denormalizer = new VarcharAttributeValueDenormalization(
                    $this->attributeRepository
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);

                return $denormalizer;
            } elseif ($attribute->getFrontendType() === 'text') {
                $denormalizer = new VarcharAttributeValueDenormalization(
                    $this->attributeRepository
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);

                return $denormalizer;
            } elseif ($attribute->getFrontendType() === 'multiselect') {
                $denormalizer = new MultipleOptionsAttributeValueDenormalization(
                    $this->attributeRepository,
                    new DefaultOptionMapper(
                        $this->optionMappingRepository->findAllByAttribute($attribute)
                    )
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);

                return $denormalizer;
            } elseif ($attribute->getFrontendType() === 'select') {
                $denormalizer = new OptionAttributeValueDenormalization(
                    $this->attributeRepository,
                    new DefaultOptionMapper(
                        $this->optionMappingRepository->findAllByAttribute($attribute)
                    )
                );
                $this->attributeDenormalizers->attach($attribute, $denormalizer);

                return $denormalizer;
            } elseif ($attribute->getFrontendType() === 'media_image') {
                // TODO: add support for media attributes
                $denormalizer = new DummyAttributeValueDenormalization();
                $this->attributeDenormalizers->attach($attribute, $denormalizer);

                return $denormalizer;
            } elseif ($attribute->getFrontendType() === 'gallery') {
                // TODO: add support for media attributes
                $denormalizer = new DummyAttributeValueDenormalization();
                $this->attributeDenormalizers->attach($attribute, $denormalizer);

                return $denormalizer;
            } else {
                throw new RuntimeErrorException('Unexpected attribute type.');
            }
        }

        throw new RuntimeErrorException('Unexpected attribute type.');
    }

    /**
     * @param mixed  $data
     * @param string $class
     * @param null   $format
     * @param array  $context
     *
     * @return ProductInterface
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if (isset($data['family'])) {
            $familyId = $this->familyMapper->map($data['family']);

            if ($familyId === null) {
                throw new RuntimeErrorException(sprintf('Product family "%s" not found.', $data['family']));
            }

            $family = $this->familyRepository->findOneById($familyId);
        } else {
            $family = $this->familyRepository->findOneByName('Default');
        }

        if (isset($data['sku'])) {
            $identifier = $data['sku'];
        } elseif (isset($data['code'])) {
            $identifier = $data['code'];
        } else {
            throw new RuntimeErrorException('No identifier field found.');
        }

        $product = new $class(
            $identifier,
            $family
        );

        if (!$product instanceof ProductInterface) {
            throw new RuntimeErrorException(sprintf('Class is not a "%s" instance.', ProductInterface::class));
        }

        if (!$product instanceof ConfigurableProductInterface) {
            throw new RuntimeErrorException(sprintf('Class is not a "%s" instance.', ConfigurableProductInterface::class));
        }

        if (isset($data['axis']) && $data['axis'] instanceof Collection) {
            $product->addAxisAttributeList($data['axis']);
        }

        $product->setVisibleInCatalogAndSearch();

        unset(
            $data['sku'],
            $data['code'],
            $data['family'],
            $data['axis'],
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

                $denormalizer = $this->selectAttributeDenormalizer($attribute);

                $value = $denormalizer->denormalize($value, AttributeValueInterface::class);

                if ($value !== null) {
                    $product->setValue($value);
                }
            }
        }

        return $product;
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
        return true;
    }
}
