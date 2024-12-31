<?php

namespace AlphaTeam\CashbackWallet\Model\CashbackWallet\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    /**
     * @inheritDoc
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => 1, 'label' => __('Active')],
            ['value' => 2, 'label' => __('Inactive')],
        ];
    }
}
