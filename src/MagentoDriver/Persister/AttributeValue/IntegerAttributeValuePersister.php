<?php

namespace Luni\Component\MagentoDriver\Persister\AttributeValue;

use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Model\IntegerAttributeValueInterface;
use Luni\Component\MagentoDriver\Persister\BaseCsvPersisterTrait;
use Luni\Component\MagentoDriver\Exception\InvalidAttributePersisterTypeException;

class IntegerAttributeValuePersister
    implements AttributeValuePersisterInterface
{
    use BaseCsvPersisterTrait;

    public function initialize()
    {
    }

    /**
     * @param AttributeValueInterface $value
     */
    public function persist(AttributeValueInterface $value)
    {
        if (!$value instanceof IntegerAttributeValueInterface) {
            throw new InvalidAttributePersisterTypeException(sprintf(
                'Invalid attribute value type for "%s", expected "%s", got "%s".',
                $value->getAttributeCode(),
                IntegerAttributeValueInterface::class,
                get_class($value)
            ));
        }

        $this->temporaryWriter->persistRow([
            'value_id'       => $value->getId(),
            'entity_type_id' => 4,
            'attribute_id'   => $value->getAttributeId(),
            'store_id'       => $value->getStoreId(),
            'entity_id'      => $value->getProductId(),
            'value'          => number_format($value->getValue(), 0),
        ]);
    }

    /**
     * @param AttributeValueInterface $value
     * @return void
     */
    public function __invoke(AttributeValueInterface $value)
    {
        $this->persist($value);
    }

    /**
     * Flushes data into the DB
     */
    public function flush()
    {
        $this->doFlush();
    }
}
