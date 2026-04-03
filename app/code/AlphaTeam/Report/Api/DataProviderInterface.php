<?php
declare(strict_types=1);

namespace AlphaTeam\Report\Api;

interface DataProviderInterface
{
    /**
     * Collects and returns a set of data as an array.
     *
     * @return array Returns an array containing the collected data.
     */
    public function collectData(): array;
}
