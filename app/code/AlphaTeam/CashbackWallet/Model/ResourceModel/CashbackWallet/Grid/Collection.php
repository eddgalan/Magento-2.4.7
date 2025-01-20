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
                'customer_name' => 'ce.firstname',
                'customer_lastname' => 'ce.lastname',
            ]
        );
        $this->addFilterToMap('customer_name', 'ce.firstname');
        $this->addFilterToMap('customer_last', 'ce.lastname');
    }
}
