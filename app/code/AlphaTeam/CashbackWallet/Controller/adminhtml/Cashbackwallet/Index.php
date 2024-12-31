<?php
declare(strict_types=1);

namespace AlphaTeam\CashbackWallet\Controller\adminhtml\Cashbackwallet;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Controller for the 'cashbackwallet_management/cashbackwallet/index' URL route.
 */
class Index extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session.
     */
    public const ADMIN_RESOURCE = 'AlphaTeam_CashbackWallet::manage_cashbackwallet';

    /**
     * Admin menu item
     */
    public const ADMIN_MENU = 'AlphaTeam_CashbackWallet::index';

    /**
     * Execute controller action.
     *
     * @return ResponseInterface|ResultInterface
     */
    public function execute(): ResultInterface|ResponseInterface
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Cashback Wallet'));
        $resultPage->setActiveMenu(static::ADMIN_MENU);

        return $resultPage;
    }
}
