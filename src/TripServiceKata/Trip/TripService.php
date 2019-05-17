<?php

namespace TripServiceKata\Trip;

use TripServiceKata\Exception\UserNotLoggedInException;
use TripServiceKata\User\User;

class TripService
{
    protected $trip_dao;

    public function __construct(TripDAO $trip_dao)
    {
        $this->trip_dao = $trip_dao;
    }

    public function getFriendsTrips(User $friend, ?User $loggedInUser)
    {
        if ($loggedInUser === null) {
            throw new UserNotLoggedInException();
        }
        return $friend->isFriendWith($loggedInUser) ?
            $this->trip_dao->tripsByUser($friend) :
            $this->noTrips();
    }

    /**
     * @return array
     */
    protected function noTrips(): array
    {
        return [];
    }
}
