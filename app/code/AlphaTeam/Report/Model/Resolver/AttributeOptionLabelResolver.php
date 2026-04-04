<?php
declare(strict_types=1);

namespace AlphaTeam\Report\Model\Resolver;

use Magento\Eav\Model\Config as EavConfig;
use Magento\Framework\Exception\LocalizedException;

class AttributeOptionLabelResolver
{
    /**
     * @var EavConfig
     */
    private EavConfig $eavConfig;

    /**
     * @var array
     */
    private array $optionMaps = [];

    /**
     * @param EavConfig $eavConfig
     */
    public function __construct(
        EavConfig $eavConfig
    ) {
        $this->eavConfig = $eavConfig;
    }

    /**
     * Resolves the raw value of an attribute to a string representation based on its options map.
     *
     * @param string $attributeCode The code of the attribute to resolve.
     * @param string|null $rawValue The raw value of the attribute. Can be null.
     * @return string The resolved string representation. Returns an empty string if
     *                the raw value is null or empty.
     * @throws LocalizedException
     */
    public function resolve(string $attributeCode, ?string $rawValue): string
    {
        if ($rawValue === null || trim($rawValue) === '') {
            return '';
        }

        $optionMap = $this->getOptionMap($attributeCode);

        $values = array_filter(array_map('trim', explode(',', $rawValue)));
        if (empty($values)) {
            return '';
        }

        $labels = [];
        foreach ($values as $value) {
            $labels[] = $optionMap[$value] ?? $value;
        }

        return implode('|', $labels);
    }

    /**
     * Retrieves a map of option values to labels for the given attribute code.
     *
     * @param string $attributeCode The attribute code to retrieve the option map for.
     * @return array An associative array where keys are option values and values are option labels.
     * @throws LocalizedException
     */
    private function getOptionMap(string $attributeCode): array
    {
        if (isset($this->optionMaps[$attributeCode])) {
            return $this->optionMaps[$attributeCode];
        }

        $attribute = $this->eavConfig->getAttribute('catalog_product', $attributeCode);

        if (!$attribute || !$attribute->getId()) {
            $this->optionMaps[$attributeCode] = [];
            return $this->optionMaps[$attributeCode];
        }

        $allOptions = $attribute->getSource()->getAllOptions(false);

        $optionMap = [];
        foreach ($allOptions as $option) {
            if (!isset($option['value'], $option['label'])) {
                continue;
            }

            $optionMap[(string)$option['value']] = (string)$option['label'];
        }

        $this->optionMaps[$attributeCode] = $optionMap;

        return $this->optionMaps[$attributeCode];
    }
}
