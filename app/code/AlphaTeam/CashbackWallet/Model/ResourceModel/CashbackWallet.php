<?php

namespace AlphaTeam\CashbackWallet\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CashbackWallet extends AbstractDb
{
    /**
     * Construct method
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init('alphateam_cashbackwallet_balance', 'entity_id');
    }
}
