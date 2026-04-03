<?php
declare(strict_types=1);

namespace AlphaTeam\Report\Model\DataProvider;

use AlphaTeam\Report\Api\DataProviderInterface;
use AlphaTeam\Report\Model\ResourceModel\AttributeReport;

class PriceDataProvider implements DataProviderInterface
{
    /**
     * @var AttributeReport $attributeResource
     */
    private AttributeReport $attributeResource;

    /**
     * @param AttributeReport $resource
     */
    public function __construct(
        AttributeReport $resource,
    ) {
        $this->attributeResource = $resource;
    }

    /**
     * Collects and retrieves data from the attribute resource.
     *
     * @return array
     */
    public function collectData(): array
    {
        return $this->attributeResource->getReportData();
    }
}
