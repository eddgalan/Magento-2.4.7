<?php

namespace AlphaTeam\CashbackWallet\Model\ResourceModel\CashbackWallet;

use AlphaTeam\CashbackWallet\Model\CashbackWallet;
use AlphaTeam\CashbackWallet\Model\ResourceModel\CashbackWallet as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(
            CashbackWallet::class,
            ResourceModel::class
        );
    }
}
