<?php
declare(strict_types=1);

namespace AlphaTeam\Report\Api;

interface ReportGeneratorInterface
{
    /**
     * Generates and returns a report as an array.
     *
     * @return array
     */
    public function generateReport(): array;
}
