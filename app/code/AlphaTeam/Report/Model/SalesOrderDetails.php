<?php
declare(strict_types=1);

namespace AlphaTeam\Report\Model;

use AlphaTeam\Report\Model\ResourceModel\SalesOrderDetails as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class SalesOrderDetails extends AbstractModel
{
    /**
     * Initialize resource model.
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(ResourceModel::class);
    }
}
