<?php


namespace Test\TripServiceKata\Trip;


use Mockery\LegacyMockInterface;
use TripServiceKata\Trip\Trip;
use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;

class UserBuilder
{
    private const GUEST = null;

    /**
     * @var User
     */
    protected $user;
    /**
     * @var LegacyMockInterface
     */
    protected $friend;
    /**
     * @var LegacyMockInterface
     */
    protected $tripService;
    /**
     * @var array<Trip>
     */
    protected $trips;


    /**
     * @return UserBuilder
     */
    public function createMainUser(): UserBuilder
    {
        $this->user = new User('user_name');
        return $this;
    }

    /**
     * @return UserBuilder
     */
    public function createGuestUser(): UserBuilder
    {
        $this->user = self::GUEST;
        return $this;
    }

    /**
     * @return UserBuilder
     */
    public function logUserInService(): UserBuilder
    {
        $this->tripService = \Mockery::mock(TripService::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $this->tripService->shouldReceive('getLoggedUser')->andReturn($this->user);
        return $this;
    }

    /**
     * @return UserBuilder
     */
    public function createFriendship(): UserBuilder
    {
        $this->friend->shouldReceive('getFriends')->andReturn([$this->user]);
        return $this;
    }

    /**
     * @return UserBuilder
     */
    public function dontCreateFriendship(): UserBuilder
    {
        $this->friend->shouldReceive('getFriends')->andReturn([]);
        return $this;
    }

    /**
     * @return UserBuilder
     */
    public function createOtherUser(): UserBuilder
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
        $this->tripService = \Mockery::mock(TripService::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $this->tripService->shouldReceive('getLoggedUser')->andReturn($this->user);
        if (!empty($this->trips)) {
            $this->tripService->shouldReceive('findTripsByUser')->withArgs([$this->friend])->andReturn($this->trips);
        }
        return $this->user;
    }

    /**
     * @param array<Trip> $trips
     *
     * @return UserBuilder
     */
    public function withTrips($trips): UserBuilder
    {
        $this->trips = $trips;
        $this->tripService->shouldReceive('findTripsByUser')->withArgs([$this->friend])->andReturn($trips);
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
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
     * @return LegacyMockInterface
     */
    public function getTripService(): LegacyMockInterface
    {
        return $this->tripService;
    }

    /**
     * @param LegacyMockInterface $tripService
     */
    public function setTripService($tripService): void
    {
        $this->tripService = $tripService;
    }
}
