<?php

namespace Test\TripServiceKata\Trip;

use PHPUnit\Framework\TestCase;
use TripServiceKata\Exception\UserNotLoggedInException;
use TripServiceKata\Trip\Trip;
use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;

class TripServiceTest extends TestCase
{
    private const GUEST = null;
    /**
     * @var TripService
     */
    private $tripService;
    private $user;
    private $friend;



    protected function setUp(): void
    {
        parent::setUp();
        $this->friend = new User('friend_name');
        $this->tripService = \Mockery::mock(TripService::class)->makePartial()->shouldAllowMockingProtectedMethods();
    }

    public function test_should_throw_an_exception_when_user_is_not_logged_in()
    {
        $this->user = self::GUEST;
        $this->tripService->shouldReceive('getLoggedUser')->andReturn($this->user);

        $this->expectException(UserNotLoggedInException::class);

        $this->tripService->getTripsByUser($this->friend);
    }

    public function test_should_return_an_empty_list_when_user_has_no_friends()
    {
        $this->user = new User('username');
        $this->tripService->shouldReceive('getLoggedUser')->andReturn($this->user);
        $this->friend = \Mockery::mock(User::class);
        $this->friend->shouldReceive('getFriends')->andReturn([]);

        $trip_list = $this->tripService->getTripsByUser($this->friend);

        $this->assertEmpty($trip_list);
    }

    public function test_should_return_friends_trips_when_users_are_friends_single_trip_version()
    {
        $this->user = new User('username');
        $trip = new Trip();
        $this->tripService->shouldReceive('getLoggedUser')->andReturn($this->user);
        $this->friend = \Mockery::mock(User::class);
        $this->friend->shouldReceive('getFriends')->andReturn([$this->user]);
        $this->tripService->shouldReceive('findTripsByUser')->withArgs([$this->friend])->andReturn([$trip]);

        $trip_list = $this->tripService->getTripsByUser($this->friend);

        $this->assertEquals([$trip], $trip_list);
    }

    public function test_should_return_friends_trips_when_users_are_friends_multiple_trips_version()
    {
        $this->user = new User('username');
        $trip1 = new Trip();
        $trip2 = new Trip();
        $this->tripService->shouldReceive('getLoggedUser')->andReturn($this->user);
        $this->friend = \Mockery::mock(User::class);
        $this->friend->shouldReceive('getFriends')->andReturn([$this->user]);
        $this->tripService->shouldReceive('findTripsByUser')->withArgs([$this->friend])->andReturn([$trip1, $trip2]);

        $trip_list = $this->tripService->getTripsByUser($this->friend);

        $this->assertEquals([$trip1, $trip2], $trip_list);
    }

}
