<?php


namespace Kiboko\Component\MagentoMapper\Transformer\AttributeOption;

use Kiboko\Component\MagentoDriver\Model\AttributeOptionValueInterface as KibokoAttributeOptionValueInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeOptionValue;
use Kiboko\Component\MagentoDriver\Repository\StoreRepositoryInterface;
use Kiboko\Component\MagentoMapper\Mapper\AttributeMapperInterface;
use Kiboko\Component\MagentoMapper\Mapper\AttributeOptionMapperInterface;
use Kiboko\Component\MagentoMapper\Mapper\AttributeOptionValueMapperInterface;
use Kiboko\Component\MagentoMapper\Transformer\AttributeOptionValueTransformerInterface;
use Pim\Component\Catalog\Model\AttributeOptionInterface as PimAttributeOptionInterface;
use Pim\Component\Catalog\Model\AttributeOptionValueInterface;

class AttributeOptionValueTransformer implements AttributeOptionValueTransformerInterface
{
    /**
     * @var AttributeOptionMapperInterface
     */
    private $attributeOptionMapper;

    /**
     * @var AttributeOptionValueMapperInterface
     */
    private $attributeOptionValueMapper;

    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;

    /**
     * @var string
     */
    private $adminLocaleCode;

    /**
     * @var string[]
     */
    private $storeLocaleCodes;

    /**
     * AttributeOptionTransformer constructor.
     * @param AttributeOptionMapperInterface $attributeOptionMapper
     * @param AttributeOptionValueMapperInterface $attributeOptionValueMapper
     * @param StoreRepositoryInterface $storeRepository
     * @param string $adminLocaleCode
     * @param array $storeLocaleCodes
     */
    public function __construct(
        AttributeOptionMapperInterface $attributeOptionMapper,
        AttributeOptionValueMapperInterface $attributeOptionValueMapper,
        StoreRepositoryInterface $storeRepository,
        $adminLocaleCode,
        array $storeLocaleCodes = []
    ) {
        $this->attributeOptionMapper = $attributeOptionMapper;
        $this->attributeOptionValueMapper = $attributeOptionValueMapper;
        $this->storeRepository = $storeRepository;
        $this->adminLocaleCode = $adminLocaleCode;
        $this->storeLocaleCodes = $storeLocaleCodes;
    }

    /**
     * @param PimAttributeOptionInterface $attributeOption
     *
     * @return KibokoAttributeOptionValueInterface[]|\Traversable
     */
    public function transform(PimAttributeOptionInterface $attributeOption)
    {
        $optionId = $this->attributeOptionMapper->map($attributeOption->getCode());
        $optionValuesCache = [];

        /** @var AttributeOptionValueInterface $value */
        foreach ($attributeOption->getOptionValues() as $value) {
            if ($value->getLocale() !== $this->adminLocaleCode) {
                continue;
            }

            if (!isset($optionValuesCache[$value->getLocale()])) {
                $optionValuesCache[$value->getLocale()] =
                    $this->attributeOptionValueMapper->map($attributeOption->getCode(), $value->getLocale());
            }

            $transformedAttributeOption = AttributeOptionValue::buildNewWith(
                $optionValuesCache[$value->getLocale()],
                $optionId,
                0, // Admin store Id
                $value->getLabel()
            );

            $transformedAttributeOption->setMappingCode($attributeOption->getCode());
            $transformedAttributeOption->setMappingLocale($attributeOption->getLocale());

            yield $transformedAttributeOption;
        }

        /** @var AttributeOptionValueInterface $value */
        foreach ($attributeOption->getOptionValues() as $value) {
            $currentLocale = $value->getLocale();

            $stores = array_filter($this->storeLocaleCodes, function($locale) use($currentLocale) {
                return $locale === $currentLocale;
            }, ARRAY_FILTER_USE_BOTH);

            foreach ($stores as $storeCode) {
                if (($store = $this->storeRepository->findOneByCode($storeCode)) === null) {
                    continue;
                }

                if (!isset($optionValuesCache[$value->getLocale()])) {
                    $optionValuesCache[$value->getLocale()] =
                        $this->attributeOptionValueMapper->map($attributeOption->getCode(), $value->getLocale());
                }

                $transformedOptionValue = AttributeOptionValue::buildNewWith(
                    $optionValuesCache[$value->getLocale()],
                    $this->attributeOptionMapper->map($attributeOption->getCode()),
                    $store->getId(),
                    $value->getLabel()
                );

                $transformedAttributeOption->setMappingCode($attributeOption->getCode());
                $transformedAttributeOption->setMappingLocale($attributeOption->getLocale());

                yield $transformedOptionValue;
            }
        }
    }

    /**
     * @param PimAttributeOptionInterface $attributeOption
     *
     * @return bool
     */
    public function supportsTransformation(PimAttributeOptionInterface $attributeOption)
    {
        return true;
    }
}
