<?php

namespace AlphaTeam\CashbackWallet\Ui\Component\Listing\Columns;

use Magento\Catalog\Ui\Component\Listing\Columns\Price as BasePrice;

class WalletCoinFormat extends BasePrice
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
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item[$this->getData('name')])) {
                    $item[$this->getData('name')] = number_format(
                        $item[$this->getData('name')],
                        2,
                        '.',
                        ','
                    );
                }
            }
        }
        return $dataSource;
    }
}
