<?php
declare(strict_types=1);

namespace AlphaTeam\Report\Controller\adminhtml\CustomReport;

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
    public const ADMIN_RESOURCE = 'AlphaTeam_Report::CustomReportsForm';

    /**
     * Admin menu item
     */
    public const ADMIN_MENU = 'Magento_Sales::report';

    /**
     * Executes the method logic to create and configure a result page.
     *
     * @return ResponseInterface|ResultInterface The configured result page.
     */
    public function execute(): ResponseInterface|ResultInterface
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Alpha Team | Custom Report'));
        $resultPage->setActiveMenu(static::ADMIN_MENU);

        return $resultPage;
    }
}
