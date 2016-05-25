<?php

namespace Kiboko\Bundle\MagentoDriverBundle\Processor;

use Akeneo\Bundle\BatchBundle\Item\AbstractConfigurableStepElement;
use Akeneo\Bundle\BatchBundle\Item\ItemProcessorInterface;
use Akeneo\Bundle\BatchBundle\Item\UnexpectedInputException;
use Akeneo\Bundle\BatchBundle\Step\StepExecutionAwareInterface;
use Kiboko\Component\MagentoMapper\Mapper\AttributeMapperInterface;
use Kiboko\Component\MagentoMapper\Transformer\AttributeTransformerInterface;
use Luni\Component\Connector\ConfigurationAwareTrait;
use Luni\Component\Connector\NameAwareTrait;
use Luni\Component\Connector\StepExecutionAwareTrait;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface as KibokoAttributeInterface;
use Pim\Bundle\CatalogBundle\Model\AttributeInterface as PimAttributeInterface;

class AttributeProcessor
    extends AbstractConfigurableStepElement
    implements ItemProcessorInterface, StepExecutionAwareInterface
{
    use StepExecutionAwareTrait;
    use ConfigurationAwareTrait;
    use NameAwareTrait;

    /**
     * @var AttributeTransformerInterface
     */
    private $attributeTransformer;

    /**
     * AttributeProcessor constructor.
     * @param AttributeTransformerInterface $attributeTransformer
     */
    public function __construct(
        AttributeTransformerInterface $attributeTransformer
    ) {
        $this->attributeTransformer = $attributeTransformer;
    }

    /**
     * @return array
     */
    public function getConfigurationFields()
    {
        return [];
    }

    /**
     * @param PimAttributeInterface $data
     *
     * @return KibokoAttributeInterface
     *
     * @throws UnexpectedInputException
     */
    public function process($data)
    {
        if ($data instanceof PimAttributeInterface) {
            throw new UnexpectedInputException(sprintf('Invalid item type, expected %s, got %s.',
                PimAttributeInterface::class, get_class($data)
            ));
        }

        $magentoAttribute = $this->attributeTransformer->transform(
            $data
        );

        return $magentoAttribute;
    }
}
