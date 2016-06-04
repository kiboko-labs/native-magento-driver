<?php

namespace Kiboko\Bundle\MagentoDriverBundle\Writer;

use Akeneo\Bundle\BatchBundle\Item\AbstractConfigurableStepElement;
use Akeneo\Bundle\BatchBundle\Item\ItemWriterInterface;
use Akeneo\Bundle\BatchBundle\Item\UnexpectedInputException;
use Akeneo\Bundle\BatchBundle\Step\StepExecutionAwareInterface;
use Kiboko\Component\MagentoDriver\Persister\AttributePersisterInterface;
use Luni\Component\Connector\ConfigurationAwareTrait;
use Luni\Component\Connector\NameAwareTrait;
use Luni\Component\Connector\StepExecutionAwareTrait;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;

class AttributeWriter
    extends AbstractConfigurableStepElement
    implements ItemWriterInterface, StepExecutionAwareInterface
{
    use StepExecutionAwareTrait;
    use ConfigurationAwareTrait;
    use NameAwareTrait;

    /**
     * @var AttributePersisterInterface
     */
    private $persister;

    public function __construct(
        AttributePersisterInterface $persister
    ) {
        $this->persister = $persister;
    }

    /**
     * @return array
     */
    public function getConfigurationFields()
    {
        return [];
    }

    /**
     * Override to add custom logic on step initialization.
     */
    public function initialize()
    {
        $this->persister->initialize();
    }

    /**
     * @param AttributeInterface[] $items
     *
     * @throws UnexpectedInputException
     */
    public function write(array $items)
    {
        foreach ($items as $item) {
            if (!$item instanceof AttributeInterface) {
                throw new UnexpectedInputException(sprintf('Invalid item type, expected %s, got %s.',
                    AttributeInterface::class, get_class($item)
                ));
            }

            $this->persister->persist($item);
        }
    }

    /**
     * Override to add custom logic on step completion.
     */
    public function flush()
    {
        $this->persister->flush();
    }
}
