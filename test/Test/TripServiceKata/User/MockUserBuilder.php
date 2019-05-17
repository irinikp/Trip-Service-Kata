<?php


namespace Test\TripServiceKata\User;


use Mockery\LegacyMockInterface;
use TripServiceKata\Trip\Trip;
use TripServiceKata\Trip\TripDAO;
use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;

class MockUserBuilder
{
    private const GUEST = null;

    /**
     * @var User
     */
    protected $logged_in_user;
    /**
     * @var LegacyMockInterface
     */
    protected $friend;
    /**
     * @var TripService
     */
    protected $tripService;
    /**
     * @var array<Trip>
     */
    protected $trips;


    /**
     * @return MockUserBuilder
     */
    public function createLoggedInUser(): MockUserBuilder
    {
        $this->logged_in_user = new User();
        return $this;
    }

    /**
     * @return MockUserBuilder
     */
    public function createGuestUser(): MockUserBuilder
    {
        $this->logged_in_user = self::GUEST;
        return $this;
    }

    /**
     * @return MockUserBuilder
     */
    public function createFriendship(): MockUserBuilder
    {
        $this->friend->shouldReceive('isFriendWith')->withArgs([$this->logged_in_user])->andReturn(true);
        return $this;
    }

    /**
     * @return MockUserBuilder
     */
    public function dontCreateFriendship(): MockUserBuilder
    {
        $this->friend->shouldReceive('isFriendWith')->withArgs([$this->logged_in_user])->andReturn(false);
        return $this;
    }

    /**
     * @return MockUserBuilder
     */
    public function createOtherUser(): MockUserBuilder
    {
        $this->friend = \Mockery::mock(User::class);
        return $this;
    }

    public function createTrips(... $trips)
    {
        $this->trips = $trips;
        return $this;
    }

    public function bind()
    {
        $trip_dao = \Mockery::mock(TripDAO::class);
        $trip_dao->shouldReceive('tripsByUser')->withArgs([$this->friend])->andReturn($this->trips);
        $this->tripService = new TripService($trip_dao);
        return $this->logged_in_user;
    }

    /**
     * @param array<Trip> $trips
     *
     * @return MockUserBuilder
     */
    public function withTrips($trips): MockUserBuilder
    {
        $this->trips = $trips;
        $trip_dao    = \Mockery::mock(TripDAO::class);
        $trip_dao->shouldReceive('tripsByUser')->withArgs([$this->friend])->andReturn($trips);
        $this->tripService = new TripService($trip_dao);
        return $this;
    }

    /**
     * @return array<Trip>
     */
    public function getTrips(): array
    {
        return $this->trips;
    }

    /**
     * @param array<Trip> $trips
     */
    public function setTrips($trips): void
    {
        $this->trips = $trips;
    }

    /**
     * @return User|null
     */
    public function getLoggedInUser(): ?User
    {
        return $this->logged_in_user;
    }

    /**
     * @param User $user
     */
    public function setLoggedInUser($user): void
    {
        $this->logged_in_user = $user;
    }

    /**
     * @return LegacyMockInterface
     */
    public function getFriend(): LegacyMockInterface
    {
        return $this->friend;
    }

    /**
     * @param LegacyMockInterface $friend
     */
    public function setFriend($friend): void
    {
        $this->friend = $friend;
    }

    /**
     * @return TripService
     */
    public function getTripService(): TripService
    {
        return $this->tripService;
    }

    /**
     * @param TripService $tripService
     */
    public function setTripService($tripService): void
    {
        $this->tripService = $tripService;
    }
}
