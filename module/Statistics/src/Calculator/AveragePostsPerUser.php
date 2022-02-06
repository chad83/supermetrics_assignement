<?php

declare(strict_types = 1);

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;

class AveragePostsPerUser extends AbstractCalculator
{
    protected const UNITS = 'posts';

    protected string $splitPeriod = '';

    /**
     * @var array
     */
    public array $totals = [];

    /**
     * @inheritDoc
     */
    protected function doAccumulate(SocialPostTo $postTo): void
    {
        $key = $postTo->getAuthorId();

        if ($this->splitPeriod === '') {
            $this->splitPeriod = $postTo->getDate()->format('F, Y');
        }

        if (!isset($this->totals[$key])) {
            $this->totals[$key] = [
                'userName' => $postTo->getAuthorName(),
                'postCount' => 0
            ];
        }

        $this->totals[$key]['postCount']++;
    }

    /**
     * @inheritDoc
     */
    public function doCalculate(): StatisticsTo
    {
        $stats = new StatisticsTo();
        foreach ($this->totals as $userId => $userPostsStatistics) {
            $child = (new StatisticsTo())
//                ->setName($this->parameters->getStatName())
                ->setSplitPeriod('')
                ->setValue($userPostsStatistics['postCount'])
                ->setAdditionalDetails($userPostsStatistics['userName'])
                ->setUnits(self::UNITS);

            $stats->addChild($child);
        }

        return $stats;
    }
}
