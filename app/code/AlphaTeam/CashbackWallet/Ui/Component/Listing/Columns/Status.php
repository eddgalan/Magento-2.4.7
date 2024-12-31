<?php

namespace AlphaTeam\CashbackWallet\Ui\Component\Listing\Columns;

use Magento\Ui\Component\Listing\Columns\Column;

class Status extends Column
{
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['status'])) {
                    $item[$name] = (int)$item['status'] === 1 ? __('Active') : __('Inactive');
                }
            }
        }

        return $dataSource;
    }
}
