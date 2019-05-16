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

    public function getTripsByUser(User $user, ?User $loggedInUser)
    {
        if ($loggedInUser === null) {
            throw new UserNotLoggedInException();
        }
        return $user->isFriendWith($loggedInUser) ?
            $this->trip_dao->tripsByUser($user) :
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
