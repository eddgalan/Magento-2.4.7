<?php

namespace AlphaTeam\CashbackWallet\Model\ResourceModel\CashbackWalletTransaction;

use AlphaTeam\CashbackWallet\Model\CashbackWalletTransaction;
use AlphaTeam\CashbackWallet\Model\ResourceModel\CashbackWalletTransaction as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Construct method
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(
            CashbackWalletTransaction::class,
            ResourceModel::class
        );
    }
}
