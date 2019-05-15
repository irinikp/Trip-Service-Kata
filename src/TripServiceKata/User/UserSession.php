<?php

namespace TripServiceKata\User;

use TripServiceKata\Exception\DependentClassCalledDuringUnitTestException;

/**
 * Class UserSession
 * @package TripServiceKata\User
 */
class UserSession
{
    /**
     * @var UserSession
     */
    private static $userSession;

    /**
     * @return UserSession
     */
    public static function getInstance()
    {
        if (self::isNewSession()) {
            self::initiateSession();
        }

        return self::getSession();
    }

    /**
     * @param User $user
     */
    public function isUserLoggedIn(User $user)
    {
        throw new DependentClassCalledDuringUnitTestException(
            'UserSession.isUserLoggedIn() should not be called in an unit test'
        );
    }

    /**
     *
     */
    public function getLoggedUser()
    {
        throw new DependentClassCalledDuringUnitTestException(
            'UserSession.getLoggedUser() should not be called in an unit test'
        );
    }

    /**
     * @return bool
     */
    protected static function isNewSession(): bool
    {
        return null === static::$userSession;
    }

    /**
     *
     */
    protected static function initiateSession(): void
    {
        static::$userSession = new UserSession();
    }

    /**
     * @return UserSession
     */
    protected static function getSession(): UserSession
    {
        return static::$userSession;
    }

}
