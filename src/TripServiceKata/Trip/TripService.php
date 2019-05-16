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
     * @param User      $user1
     * @param User|null $user2
     *
     * @return bool
     */
    protected function areFriends(User $user1, ?User $user2): bool
    {
        $isFriend = false;
        if (null === $user2) return $isFriend;
        foreach ($user1->getFriends() as $friend) {
            if ($friend == $user2) {
                $isFriend = true;
                break;
            }
        }
        return $isFriend;
    }

    /**
     * @return array
     */
    protected function noTrips(): array
    {
        return [];
    }
}
