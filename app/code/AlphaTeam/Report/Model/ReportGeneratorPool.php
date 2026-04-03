<?php
declare(strict_types=1);

namespace AlphaTeam\Report\Model;

use AlphaTeam\Report\Api\ReportGeneratorInterface;
use Magento\Framework\Exception\LocalizedException;

class ReportGeneratorPool
{
    /**
     * @var ReportGeneratorInterface[]
     */
    private array $generators;

    /**
     * @param ReportGeneratorInterface[] $generators
     */
    public function __construct(array $generators = [])
    {
        $this->generators = $generators;
    }

    /**
     * Retrieves the report generator associated with the specified type.
     *
     * @param string $type
     * @return ReportGeneratorInterface
     * @throws LocalizedException
     */
    public function get(string $type): ReportGeneratorInterface
    {
        if (!isset($this->generators[$type])) {
            throw new LocalizedException(__('Unknown report type "%1"', $type));
        }

        return $this->generators[$type];
    }

    /**
     * Filters and retrieves reports based on the provided list of keys.
     *
     * @param array $list An array of keys to filter reports.
     * @return array Returns an array of filtered reports matching the provided keys.
     */
    public function getReports(array $list): array
    {
        return array_filter($this->generators, function ($key) use ($list) {
            return in_array($key, $list);
        }, ARRAY_FILTER_USE_KEY);
    }
}
