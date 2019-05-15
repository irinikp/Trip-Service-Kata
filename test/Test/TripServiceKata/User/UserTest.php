<?php

namespace Test\TripServiceKata\Trip;

use PHPUnit\Framework\TestCase;
use TripServiceKata\Trip\Trip;
use TripServiceKata\User\User;

require __DIR__ . '/../../../../vendor/autoload.php';

class UserTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->user = new User('user_name');
    }

    public function test_new_user_has_no_friends()
    {
        $this->assertEmpty($this->user->getFriends());
    }

    public function test_new_user_has_no_trips()
    {
        $this->assertEmpty($this->user->getTrips());
    }

    public function test_when_adding_a_friend_it_is_contained_in_friends_list()
    {
        $friend = new User('friend_name');
        $this->user->addFriend($friend);
        $this->assertContains($friend, $this->user->getFriends());
    }

    public function test_friends_list_contains_all_added_friends()
    {
        $friend1 = new User('friend_name1');
        $friend2 = new User('friend_name2');
        $this->user->addFriend($friend1);
        $this->user->addFriend($friend2);
        $this->assertEquals([$friend1, $friend2], $this->user->getFriends());
    }

    public function test_not_friend_user_in_not_contained_in_friends_list()
    {
        $friend1    = new User('friend_name1');
        $non_friend = new User('non_friend_name');
        $this->user->addFriend($friend1);
        $this->assertNotContains($non_friend, $this->user->getFriends());
    }

    public function test_when_adding_a_trip_it_is_contained_in_trips_list()
    {
        $trip = new Trip();
        $this->user->addTrip($trip);
        $this->assertContains($trip, $this->user->getTrips());
    }

    public function test_trips_list_contains_all_added_trips()
    {
        $trip1 = new Trip();
        $trip2 = new Trip();
        $this->user->addTrip($trip1);
        $this->user->addTrip($trip2);
        $this->assertEquals([$trip1, $trip2], $this->user->getTrips());
    }

    public function test_not_trip_user_in_not_contained_in_trips_list()
    {
        $trip1          = new Trip();
        $non_added_trip = new Trip();
        $this->user->addTrip($trip1);
        $this->assertNotContains($non_added_trip, $this->user->getTrips());
    }
}
