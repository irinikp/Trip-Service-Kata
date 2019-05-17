<?php

namespace Test\TripServiceKata\Trip;

use PHPUnit\Framework\TestCase;
use Test\TripServiceKata\User\MockUserBuilder;
use TripServiceKata\Exception\UserNotLoggedInException;
use TripServiceKata\Trip\Trip;
use TripServiceKata\User\User;

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
            ->bind();
        $no_friend = new User();

        $this->expectException(UserNotLoggedInException::class);

        $this->user_builder->getTripService()->getFriendsTrips($no_friend, $this->user_builder->getLoggedInUser());
    }

    public function test_should_return_no_trips_when_logged_in_user_has_no_friends()
    {
        $this->user_builder->createLoggedInUser()
        ->bind();
        $no_friend = new User();

        $trip_list = $this->user_builder->getTripService()->getFriendsTrips($no_friend, $this->user_builder->getLoggedInUser());

        $this->assertEmpty($trip_list);
    }

    public function test_should_return_no_trips_when_user_is_not_friend_with_logged_in_user()
    {
        $this->user_builder->createLoggedInUser()
            ->createOtherUser()
            ->dontCreateFriendship()
            ->bind();

        $trip_list = $this->user_builder->getTripService()->getFriendsTrips($this->user_builder->getFriend(), $this->user_builder->getLoggedInUser());

        $this->assertEmpty($trip_list);
    }


    public function test_should_return_no_trips_when_friend_has_no_trips()
    {
        $this->user_builder->createLoggedInUser()
            ->createOtherUser()
            ->createFriendship()
            ->bind();

        $trip_list = $this->user_builder->getTripService()->getFriendsTrips($this->user_builder->getFriend(), $this->user_builder->getLoggedInUser());

        $this->assertEmpty($trip_list);
    }

    public function test_should_return_friends_trips_when_users_are_friends_single_trip_version()
    {
        $this->user_builder->createLoggedInUser()
            ->createOtherUser()
            ->createFriendship()
            ->createTrips(new Trip())
            ->bind();

        $trip_list = $this->user_builder->getTripService()->getFriendsTrips($this->user_builder->getFriend(), $this->user_builder->getLoggedInUser());

        $this->assertEquals($this->user_builder->getTrips(), $trip_list);
    }

    public function test_should_return_friends_trips_when_users_are_friends_multiple_trips_version()
    {
        $this->user_builder->createLoggedInUser()
            ->createOtherUser()
            ->createFriendship()
            ->createTrips(new Trip(), new Trip())
            ->bind();

        $trip_list = $this->user_builder->getTripService()->getFriendsTrips($this->user_builder->getFriend(), $this->user_builder->getLoggedInUser());

        $this->assertEquals($this->user_builder->getTrips(), $trip_list);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user_builder = new MockUserBuilder();
    }

}
