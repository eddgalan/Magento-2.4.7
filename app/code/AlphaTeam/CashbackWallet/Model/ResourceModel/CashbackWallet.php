<?php

namespace AlphaTeam\CashbackWallet\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CashbackWallet extends AbstractDb
{
    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init('cashback_wallet', 'entity_id');
    }
}
