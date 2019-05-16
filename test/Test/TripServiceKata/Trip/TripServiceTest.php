<?php

namespace Test\TripServiceKata\Trip;

use PHPUnit\Framework\TestCase;
use Test\TripServiceKata\User\MockUserBuilder;
use TripServiceKata\Exception\UserNotLoggedInException;
use TripServiceKata\Trip\Trip;

require __DIR__ . '/../../../../vendor/autoload.php';

class TripServiceTest extends TestCase
{
    /**
     * @var MockUserBuilder
     */
    private $user_builder;

    public function test_should_throw_an_exception_when_user_is_not_logged_in()
    {
        $this->user_builder->createGuestUser()
            ->createOtherUser()
            ->bind();

        $this->expectException(UserNotLoggedInException::class);

        $this->user_builder->getTripService()->getTripsByUser($this->user_builder->getFriend());
    }

    public function test_should_return_no_trips_when_user_has_no_friends()
    {
        $this->user_builder->createMainUser()
            ->createOtherUser()
            ->dontCreateFriendship()
            ->bind();

        $trip_list = $this->user_builder->getTripService()->getTripsByUser($this->user_builder->getFriend());

        $this->assertEmpty($trip_list);
    }

    public function test_should_return_friends_trips_when_users_are_friends_single_trip_version()
    {
        $this->user_builder->createMainUser()
            ->createOtherUser()
            ->createFriendship()
            ->createTrips(new Trip())
            ->bind();

        $trip_list = $this->user_builder->getTripService()->getTripsByUser($this->user_builder->getFriend());

        $this->assertEquals($this->user_builder->getTrips(), $trip_list);
    }

    public function test_should_return_friends_trips_when_users_are_friends_multiple_trips_version()
    {
        $this->user_builder->createMainUser()
            ->createOtherUser()
            ->createFriendship()
            ->createTrips(new Trip(), new Trip())
            ->bind();

        $trip_list = $this->user_builder->getTripService()->getTripsByUser($this->user_builder->getFriend());

        $this->assertEquals($this->user_builder->getTrips(), $trip_list);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user_builder = new MockUserBuilder();
    }

}
