<?php
declare(strict_types=1);

namespace AlphaTeam\Report\Model\Config\Source;

class ReportsList implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Converts data into an array of options suitable for form dropdowns or selection inputs.
     *
     * @return array The array of options, each consisting of 'value' and 'label' keys.
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => 'attribute_report',
                'label' => __('Attribute Report')
            ]
        ];
    }

    /**
     * Converts the provided data into an array format.
     *
     * @return array The formatted array containing 'value' and 'label' keys for each entry.
     */
    public function toArray(): array
    {
        $options = [];
        foreach ($this->toOptionArray() as $value => $label) {
            $options[] = ['value' => $value, 'label' => $label];
        }

        return $options;
    }
}
