<?php
declare(strict_types=1);

namespace AlphaTeam\Report\Controller\adminhtml\SalesOrderDetails;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session.
     */
    public const ADMIN_RESOURCE = 'AlphaTeam_Report::SalesOrderDetails';

    /**
     * Admin menu item
     */
    public const ADMIN_MENU = 'Magento_Sales::sales';

    /**
     * Executes the controller action to generate and return the sales order details page.
     *
     * @return ResponseInterface|ResultInterface
     */
    public function execute(): ResponseInterface|ResultInterface
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Sales Order Details'));
        $resultPage->setActiveMenu(static::ADMIN_MENU);

        return $resultPage;
    }
}
