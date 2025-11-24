<?php
declare(strict_types=1);

namespace AlphaTeam\Report\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class SalesOrderDetails extends AbstractDb
{
    /**
     * Initialize the model by setting the resource model and primary key.
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init('sales_order', 'entity_id');
    }
}
