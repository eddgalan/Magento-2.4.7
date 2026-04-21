<?php
declare(strict_types=1);

namespace AlphaTeam\Report\Model\DataProvider;

use AlphaTeam\Report\Api\DataProviderInterface;
use AlphaTeam\Report\Model\ResourceModel\AttributeReport;

class PriceDataProvider implements DataProviderInterface
{
    public const ATTRIBUTE_CODE = 'price';
    public const PRODUCT_TYPE = 'simple';

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
     * Collects and yields data in batches from the attribute resource.
     *
     * @return iterable An iterable collection of data rows, each containing 'sku' and 'value' keys.
     */
    public function collectData(): iterable
    {
        foreach ($this->attributeResource->getReportDataBatches(self::ATTRIBUTE_CODE, self::PRODUCT_TYPE) as $batch) {
            foreach ($batch as $row) {
                yield [
                    'sku' => $row['sku'] ?? '',
                    'value' => $row['value'] ?? ''
                ];
            }
        }
    }
}
