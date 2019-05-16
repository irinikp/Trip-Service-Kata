<?php

namespace TripServiceKata\User;

use TripServiceKata\Trip\Trip;

/**
 * Class User
 * @package TripServiceKata\User
 */
class User
{
    /**
     * @var array<Trip>
     */
    private $trips;
    /**
     * @var array<User>
     */
    private $friends;
    /**
     * @var string
     */
    private $name;

    /**
     * User constructor.
     *
     */
    public function __construct()
    {
        $this->name    = '';
        $this->trips   = [];
        $this->friends = [];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return array<Trip>
     */
    public function getTrips(): array
    {
        return $this->trips;
    }

    /**
     * @return array<User>
     */
    public function getFriends(): array
    {
        return $this->friends;
    }

    /**
     * @param User $user
     */
    public function addFriend(User $user): void
    {
        array_push($this->friends, $user);
    }

    /**
     * @param Trip $trip
     */
    public function addTrip(Trip $trip): void
    {
        array_push($this->trips, $trip);
    }

    /**
     * @param User|null $friend
     *
     * @return bool
     */
    public function isFriendWith(?User $friend): bool
    {
        return (null === $friend) ?
            false :
            contains($this->getFriends(), $friend);
    }
}
