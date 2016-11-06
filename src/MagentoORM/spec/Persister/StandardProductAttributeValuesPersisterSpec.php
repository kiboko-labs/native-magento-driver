<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace spec\Kiboko\Component\MagentoORM\Persister;

use Doctrine\Common\Collections\Collection;
use Kiboko\Component\MagentoORM\Persister\AttributeValuePersisterInterface;
use Kiboko\Component\MagentoORM\Persister\StandardProductAttributeValuesPersister;
use PhpSpec\ObjectBehavior;

class StandardProductAttributeValuesPersisterSpec extends ObjectBehavior
{
    public function it_is_initializable(
        AttributeValuePersisterInterface $persister,
        Collection $collection
    ) {
        $this->beConstructedWith($persister, $collection);
        $this->shouldHaveType(StandardProductAttributeValuesPersister::class);
    }
}
