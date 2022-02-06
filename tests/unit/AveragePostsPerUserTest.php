<?php

namespace Tests\unit;

use PHPUnit\Framework\TestCase;
use Statistics\Calculator\AveragePostsPerUser;
use Statistics\Dto\ParamsTo;
use Statistics\Dto\StatisticsTo;
use Statistics\Enum\StatsEnum;

class AveragePostsPerUserTest extends TestCase
{
    protected ParamsTo $paramsTo;

    protected function setUp(): void
    {
        $this->paramsTo = $this->createMock(ParamsTo::class);
    }

    public function testDoCalculate()
    {
        $averagePostsPerUser = new AveragePostsPerUser();

        $averagePostsPerUser->totals = [
            0 => ['userName' => 'testUser1', 'postCount' => 3],
            1 => ['userName' => 'testUser2', 'postCount' => 2],
            2 => ['userName' => 'testUser3', 'postCount' => 32],
        ];

        $this->paramsTo->method('getStatName')->willReturn(StatsEnum::AVERAGE_POST_NUMBER_PER_USER);

        $averagePostsPerUserCalculate = $averagePostsPerUser->doCalculate();

        $this->assertInstanceOf(StatisticsTo::class, $averagePostsPerUserCalculate);
        $this->assertCount(3, $averagePostsPerUserCalculate->getChildren());
        $this->assertInstanceOf(StatisticsTo::class, $averagePostsPerUserCalculate->getChildren()[0]);
    }
}