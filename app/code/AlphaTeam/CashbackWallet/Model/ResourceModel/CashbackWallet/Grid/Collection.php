<?php

namespace AlphaTeam\CashbackWallet\Model\ResourceModel\CashbackWallet\Grid;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class Collection extends SearchResult
{
    /**
     * @return void
     */
    protected function _initSelect(): void
    {
        parent::_initSelect();
        $this->getSelect()->joinLeft(
            ['ce' => $this->getTable('customer_entity')],
            'main_table.customer_id = ce.entity_id',
            [
                'customer_name' => new \Zend_Db_Expr("CONCAT(ce.firstname, ' ', ce.lastname)")
            ]
        );
    }
}
