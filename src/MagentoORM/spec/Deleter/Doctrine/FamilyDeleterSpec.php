<?php

namespace spec\Kiboko\Component\MagentoORM\Deleter\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\FamilyQueryBuilderInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FamilyDeleterSpec extends ObjectBehavior
{
    function it_is_initializable(
        Connection $connection,
        FamilyQueryBuilderInterface $queryBuilder
    ) {
        $this->beConstructedWith($connection, $queryBuilder);
        $this->shouldHaveType('Kiboko\Component\MagentoORM\Deleter\Doctrine\FamilyDeleter');
    }
}
