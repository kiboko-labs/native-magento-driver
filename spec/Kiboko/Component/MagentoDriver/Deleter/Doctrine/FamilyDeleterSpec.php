<?php

namespace spec\Kiboko\Component\MagentoDriver\Deleter\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\FamilyQueryBuilderInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FamilyDeleterSpec extends ObjectBehavior
{
    function it_is_initializable(
        Connection $connection,
        FamilyQueryBuilderInterface $queryBuilder
    ) {
        $this->beConstructedWith($connection, $queryBuilder);
        $this->shouldHaveType('Kiboko\Component\MagentoDriver\Deleter\Doctrine\FamilyDeleter');
    }
}
