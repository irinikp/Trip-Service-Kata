<?php

namespace Test\TripServiceKata\Trip;

use PHPUnit\Framework\TestCase;
use TripServiceKata\Trip\TripService;

class TripServiceTest extends TestCase
{
    /**
     * @var TripService
     */
    private $tripService;


    protected function setUp(): void
    {
        parent::setUp();
        $this->tripService = new TripService;
    }

    /** @test */
    public function it_does_something()
    {
        $this->assertTrue(false);
    }
}
