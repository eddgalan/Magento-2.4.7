<?php
declare(strict_types=1);

namespace AlphaTeam\Report\Model\DataProvider;

use AlphaTeam\Report\Api\DataProviderInterface;
use AlphaTeam\Report\Model\ResourceModel\AttributeReport;
use AlphaTeam\Report\Model\Resolver\AttributeOptionLabelResolver;
use Magento\Framework\Exception\LocalizedException;

class ActivityDataProvider implements DataProviderInterface
{
    public const ATTRIBUTE_CODE = 'activity';
    public const PRODUCT_TYPE = 'simple';

    /**
     * @var AttributeReport $attributeResource
     */
    private AttributeReport $attributeResource;

    /**
     * @var AttributeOptionLabelResolver $attributeOptionLabelResolver
     */
    private AttributeOptionLabelResolver $attributeOptionLabelResolver;

    /**
     * @param AttributeReport $resource
     * @param AttributeOptionLabelResolver $attributeOptionLabelResolver
     */
    public function __construct(
        AttributeReport $resource,
        AttributeOptionLabelResolver $attributeOptionLabelResolver
    ) {
        $this->attributeResource = $resource;
        $this->attributeOptionLabelResolver = $attributeOptionLabelResolver;
    }

    /**
     * Collects and retrieves data from the attribute resource.
     *
     * @return array
     * @throws LocalizedException
     */
    public function collectData(): array
    {
        $data = $this->attributeResource->getReportData(self::ATTRIBUTE_CODE, self::PRODUCT_TYPE);

        foreach ($data as &$row) {
            if (!isset($row['value'])) {
                continue;
            }

            $row['value'] = $this->attributeOptionLabelResolver->resolve(
                self::ATTRIBUTE_CODE,
                (string)$row['value']
            );
        }

        unset($row);

        return $data;
    }
}
