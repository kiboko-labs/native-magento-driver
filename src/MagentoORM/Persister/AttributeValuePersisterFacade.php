<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister;

use Kiboko\Component\MagentoORM\Model\AttributeValueInterface;
use Kiboko\Component\MagentoORM\Broker\ProductAttributeValuePersisterBrokerInterface;

class AttributeValuePersisterFacade implements AttributeValuePersisterInterface
{
    /**
     * @var ProductAttributeValuePersisterBrokerInterface
     */
    private $broker;

    public function __construct(ProductAttributeValuePersisterBrokerInterface $broker)
    {
        $this->broker = $broker;
    }

    public function initialize()
    {
        foreach ($this->broker->walkPersisterList() as $backend) {
            $backend->initialize();
        }
    }

    /**
     * @param AttributeValueInterface $value
     */
    public function persist(AttributeValueInterface $value)
    {
        $backend = $this->broker->findFor($value->getAttribute());

        if ($backend === null) {
            return;
        }

        $backend->persist($value);
    }

    public function __invoke(AttributeValueInterface $value)
    {
        $this->persist($value);
    }

    /**
     * @return \Traversable
     */
    public function flush()
    {
        foreach ($this->broker->walkPersisterList() as $backend) {
            $backend->flush();
        }
    }
}
