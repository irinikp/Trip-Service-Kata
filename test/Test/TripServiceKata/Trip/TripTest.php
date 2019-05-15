<?php

namespace Test\TripServiceKata\Trip;

use PHPUnit\Framework\TestCase;
use TripServiceKata\Exception\DependentClassCalledDuringUnitTestException;
use TripServiceKata\Trip\TripDAO;
use TripServiceKata\User\User;

require __DIR__ . '/../../../../vendor/autoload.php';

class TripTest extends TestCase
{
    public function test_find_trips_by_user_throws_exception()
    {
        $this->expectException(DependentClassCalledDuringUnitTestException::class);
        TripDAO::findTripsByUser(new User('user_name'));

    }
}
