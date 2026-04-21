<?php
declare(strict_types=1);

namespace AlphaTeam\Report\Api;

interface DataProviderInterface
{

    /**
     * Gathers and returns a collection of data.
     *
     * @return iterable Returns an iterable collection of data.
     */
    public function collectData(): iterable;
}
