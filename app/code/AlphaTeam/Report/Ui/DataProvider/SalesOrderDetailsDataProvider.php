<?php

declare(strict_types=1);

namespace AlphaTeam\Report\Ui\DataProvider;

use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;

class SalesOrderDetailsDataProvider extends DataProvider
{
    /**
     * @var TimezoneInterface $timezone
     */
    private TimezoneInterface $timezone;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ReportingInterface $reporting
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param RequestInterface $request
     * @param FilterBuilder $filterBuilder
     * @param TimezoneInterface $timezone
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        TimezoneInterface $timezone,
        array $meta = [],
        array $data = []
    ) {
        $this->timezone = $timezone;

        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
    }

    /**
     * Retrieves and processes data
     *
     * @return array Processed data with local time adjustments for timestamps where applicable.
     * @throws \DateMalformedStringException
     */
    public function getData(): array
    {
        $data = parent::getData();

        if (!isset($data['items']) || !is_array($data['items'])) {
            return $data;
        }

        foreach ($data['items'] as &$item) {
            if (!empty($item['created_at'])) {
                $item['created_at'] = $this->convertToLocalTime($item['created_at']);
            }

            if (!empty($item['updated_at'])) {
                $item['updated_at'] = $this->convertToLocalTime($item['updated_at']);
            }
        }

        return $data;
    }

    /**
     * Converts a UTC date-time string to the local date-time string based on the configured timezone.
     *
     * @param string $dbDateTime The date-time string in UTC format.
     * @return string The formatted local date-time string.
     * @throws \DateMalformedStringException
     */
    private function convertToLocalTime(string $dbDateTime): string
    {
        $date = new \DateTime($dbDateTime, new \DateTimeZone('UTC'));
        $localDate = $this->timezone->date($date);

        return $localDate->format('Y-m-d H:i:s');
    }
}
