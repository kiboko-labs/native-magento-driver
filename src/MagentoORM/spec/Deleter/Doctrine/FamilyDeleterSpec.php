<?php

namespace spec\Kiboko\Component\MagentoORM\Deleter\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\FamilyQueryBuilderInterface;
use PhpSpec\ObjectBehavior;

class FamilyDeleterSpec extends ObjectBehavior
{
    public function it_is_initializable(
        Connection $connection,
        FamilyQueryBuilderInterface $queryBuilder
    ) {
        $this->beConstructedWith($connection, $queryBuilder);
        $this->shouldHaveType('Kiboko\Component\MagentoORM\Deleter\Doctrine\FamilyDeleter');
    }
}
