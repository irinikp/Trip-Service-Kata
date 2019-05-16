<?php

namespace TripServiceKata\Trip;

use TripServiceKata\User\User;
use TripServiceKata\User\UserSession;
use TripServiceKata\Exception\UserNotLoggedInException;

class TripService
{
    public function getTripsByUser(User $user, ?User $loggedInUser)
    {
        if ($loggedInUser === null) {
            throw new UserNotLoggedInException();
        }
        return $this->areFriends($user, $loggedInUser) ? $this->findTripsByUser($user) : $this->noTrips();
    }

    /**
     * @param User $user
     *
     * @return array<Trip>
     */
    protected function findTripsByUser(User $user): array
    {
        $tripList = TripDAO::findTripsByUser($user);
        return $tripList;
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
