<?php

namespace Tests\unit;

use PHPUnit\Framework\TestCase;
use Statistics\Calculator\NoopCalculator;
use Statistics\Dto\ParamsTo;
use Statistics\Dto\StatisticsTo;
use Statistics\Enum\StatsEnum;

class NoopCalculatorTest extends TestCase
{
    protected ParamsTo $paramsTo;

    protected function setUp(): void
    {
        $this->paramsTo = $this->createMock(ParamsTo::class);
    }

    public function testDoCalculate()
    {
        $noopCalculator = new NoopCalculator();

        $noopCalculator->totals = [
            0 => ['userName' => 'testUser1', 'postCount' => 3],
            1 => ['userName' => 'testUser2', 'postCount' => 2],
            2 => ['userName' => 'testUser3', 'postCount' => 32],
        ];

        $this->paramsTo->method('getStatName')->willReturn(StatsEnum::AVERAGE_POST_NUMBER_PER_USER);

        $noopCalculatorCalculate = $noopCalculator->doCalculate();

        $this->assertInstanceOf(StatisticsTo::class, $noopCalculatorCalculate);
        $this->assertCount(3, $noopCalculatorCalculate->getChildren());
        $this->assertInstanceOf(StatisticsTo::class, $noopCalculatorCalculate->getChildren()[0]);
    }
}