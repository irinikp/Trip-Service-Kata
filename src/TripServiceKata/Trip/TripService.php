<?php

namespace TripServiceKata\Trip;

use TripServiceKata\User\User;
use TripServiceKata\User\UserSession;
use TripServiceKata\Exception\UserNotLoggedInException;

class TripService
{
    public function getTripsByUser(User $user) {
        $tripList = array();
        $loggedUser = $this->getLoggedUser();
        $isFriend = false;
        if ($loggedUser != null) {
            foreach ($user->getFriends() as $friend) {
                if ($friend == $loggedUser) {
                    $isFriend = true;
                    break;
                }
            }
            if ($isFriend) {
                $tripList = $this->findTripsByUser($user);
            }
            return $tripList;
        } else {
            throw new UserNotLoggedInException();
        }
    }

    protected function getLoggedUser(): ?User
    {
        $loggedUser = UserSession::getInstance()->getLoggedUser();
        return $loggedUser;
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
}
