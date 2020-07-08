<?php

namespace Tests\Unit;

use App\Services\CalculateService;
use PHPUnit\Framework\TestCase;

class TestTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * Add function.
     */
    public function testAdd()
    {
        $calculateService = new CalculateService;

        $this->assertEquals(6, $calculateService->add(2, 4));
    }

    /**
     * Reduce function.
     */
    public function testReduce()
    {
        $calculateService = new CalculateService;

        $this->assertEquals(-2, $calculateService->reduce(2, 4));
    }
}
