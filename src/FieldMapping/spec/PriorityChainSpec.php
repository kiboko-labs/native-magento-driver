<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace spec\Kiboko\Component\FieldMapping;

use Kiboko\Component\FieldMapping\PriorityChain;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PriorityChainSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PriorityChain::class);
    }

    function it_is_countable()
    {
        $this->shouldImplement(\Countable::class);
    }

    function it_is_traversable()
    {
        $this->shouldImplement(\Traversable::class);
    }

    function it_is_array_accessible()
    {
        $this->shouldImplement(\ArrayAccess::class);
    }

    function it_is_using_priority()
    {
        $object1 = new class { };
        $object2 = new class { };
        $object3 = new class { };
        $object4 = new class { };

        $this->attach($object1, 200);
        $this->attach($object2, 50);
        $this->attach($object3, 150);
        $this->attach($object4, 50);

        $this->getIterator()->shouldIterateAs(new \ArrayIterator([$object2, $object4, $object3, $object1]));
    }

    public function getMatchers()
    {
        return [
            'iterateAs' => function (\Traversable $subject, \Iterator $expected) {
                $expected->rewind();
                foreach ($subject as $element) {
                    if (!$expected->valid()) {
                        throw new FailureException('Iterable does contain more data than expected.');
                    }

                    if ($element !== $expected->current()) {
                        throw new FailureException(sprintf('Item %d does not match data as expected.', $expected->key()));
                    }

                    $expected->next();
                }

                if ($expected->valid()) {
                    throw new FailureException('Iterable contains less data than expected.');
                }

                return true;
            }
        ];
    }
}
