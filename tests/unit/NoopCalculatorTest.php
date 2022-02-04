<?php

namespace Tests\unit;

use PHPUnit\Framework\TestCase;
use Statistics\Calculator\NoopCalculator;
use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\ParamsTo;
use Statistics\Enum\StatsEnum;

class NoopCalculatorTest extends TestCase
{
    protected ParamsTo $paramsTo;

    protected function setUp(): void
    {
//        $this->noopCalculator = $this->createMock(NoopCalculator::class);
        $this->paramsTo = $this->createMock(ParamsTo::class);
    }

//    public function testDoAccumulate()
//    {
//
//    }

    public function testTestable()
    {
        $socialPostTo = new SocialPostTo();

        $testable = new NoopCalculator();



        $testable->totals = [
            0 => [],
        ];

        $this->paramsTo->method('getStatName')->willReturn(StatsEnum::AVERAGE_POST_NUMBER_PER_USER);

        $testableReturn = $testable->testable();
        $this->assertEquals(42, $testableReturn);
    }
}