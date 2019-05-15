<?php

namespace Test\TripServiceKata\Trip;

use PHPUnit\Framework\TestCase;
use TripServiceKata\Exception\DependentClassCalledDuringUnitTestException;
use TripServiceKata\User\User;
use TripServiceKata\User\UserSession;

require __DIR__ . '/../../../../vendor/autoload.php';

class UserSessionTest extends TestCase
{
    public function test_getInstance_returns_new_user_session_when_non_exists()
    {
        $user_session = UserSession::getInstance();
        $this->assertInstanceOf(UserSession::class, $user_session);
    }

    public function test_getInstance_returns_the_same_session_after_initialization()
    {
        $user_session1 = UserSession::getInstance();
        $user_session2 = UserSession::getInstance();
        $this->assertEquals($user_session1, $user_session2);
    }

    public function test_isUserLoggedIn_throws_exception()
    {
        $this->expectException(DependentClassCalledDuringUnitTestException::class);
        UserSession::getInstance()->isUserLoggedIn(new User('user_name'));
    }

    public function test_getLoggedUser_throws_exception()
    {
        $this->expectException(DependentClassCalledDuringUnitTestException::class);
        UserSession::getInstance()->getLoggedUser();
    }
}
