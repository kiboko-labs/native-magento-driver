<?php


namespace Kiboko\Component\MagentoMapper\Transformer\AttributeOption;

use Kiboko\Component\MagentoDriver\Model\AttributeOption;
use Kiboko\Component\MagentoDriver\Model\AttributeOptionInterface as KibokoAttributeOptionInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeOptionValue;
use Kiboko\Component\MagentoDriver\Repository\StoreRepositoryInterface;
use Kiboko\Component\MagentoMapper\Mapper\AttributeMapperInterface;
use Kiboko\Component\MagentoMapper\Mapper\AttributeOptionMapperInterface;
use Kiboko\Component\MagentoMapper\Mapper\AttributeOptionValueMapperInterface;
use Kiboko\Component\MagentoMapper\Transformer\AttributeOptionTransformerInterface;
use Pim\Component\Catalog\Model\AttributeOptionInterface as PimAttributeOptionInterface;
use Pim\Component\Catalog\Model\AttributeOptionValueInterface;

class AttributeOptionTransformer implements AttributeOptionTransformerInterface
{
    /**
     * @var AttributeMapperInterface
     */
    private $attributeMapper;

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
     * @param AttributeMapperInterface $attributeMapper
     * @param AttributeOptionMapperInterface $attributeOptionMapper
     * @param AttributeOptionValueMapperInterface $attributeOptionValueMapper
     * @param StoreRepositoryInterface $storeRepository
     * @param string $adminLocaleCode
     * @param array $storeLocaleCodes
     */
    public function __construct(
        AttributeMapperInterface $attributeMapper,
        AttributeOptionMapperInterface $attributeOptionMapper,
        AttributeOptionValueMapperInterface $attributeOptionValueMapper,
        StoreRepositoryInterface $storeRepository,
        $adminLocaleCode,
        array $storeLocaleCodes = []
    ) {
        $this->attributeMapper = $attributeMapper;
        $this->attributeOptionMapper = $attributeOptionMapper;
        $this->attributeOptionValueMapper = $attributeOptionValueMapper;
        $this->storeRepository = $storeRepository;
        $this->adminLocaleCode = $adminLocaleCode;
        $this->storeLocaleCodes = $storeLocaleCodes;
    }

    /**
     * @param PimAttributeOptionInterface $attributeOption
     *
     * @return KibokoAttributeOptionInterface
     */
    public function transform(PimAttributeOptionInterface $attributeOption)
    {
        $option = AttributeOption::buildNewWith(
            $this->attributeOptionMapper->map($attributeOption->getCode()),
            $this->attributeMapper->map($attributeOption->getAttribute()->getCode()),
            $attributeOption->getSortOrder()
        );

        /** @var AttributeOptionValueInterface $value */
        foreach ($attributeOption->getOptionValues() as $value) {

            if ($value->getLocale() !== $this->adminLocaleCode) {
                continue;
            }

            $option->addValue(
                AttributeOptionValue::buildNewWith(
                    $this->attributeOptionValueMapper->map(sprintf('%s:%d',
                        $attributeOption->getCode(), $value->getLocale())),
                    $option->getId(),
                    0, // Admin store Id
                    $value->getLabel()
                )
            );
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

                $option->addValue(
                    AttributeOptionValue::buildNewWith(
                        $this->attributeOptionValueMapper->map(sprintf('%s:%d',
                            $attributeOption->getCode(), $value->getLocale())),
                        $option->getId(),
                        $store->getId(),
                        $value->getLabel()
                    )
                );
            }
        }

        return [
            $attributeOption->getCode() => $option
        ];
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
