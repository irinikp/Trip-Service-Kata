<?php

namespace Test\TripServiceKata\Trip;

use PHPUnit\Framework\TestCase;
use TripServiceKata\Exception\DependentClassCalledDuringUnitTestException;
use TripServiceKata\Trip\TripDAO;
use TripServiceKata\User\User;

require __DIR__ . '/../../../../vendor/autoload.php';

class TripDAOTest extends TestCase
{
    public function test_find_trips_by_user_throws_exception()
    {
        $this->expectException(DependentClassCalledDuringUnitTestException::class);
        (new TripDAO())->tripsByUser(new User());
    }
}
