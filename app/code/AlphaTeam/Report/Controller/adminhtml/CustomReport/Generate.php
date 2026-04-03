<?php
declare(strict_types=1);

namespace AlphaTeam\Report\Controller\adminhtml\CustomReport;

use AlphaTeam\Report\Model\ReportGeneratorPool;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\App\Filesystem\DirectoryList;

class Generate extends Action
{
    public const ADMIN_RESOURCE = 'AlphaTeam_Report::CustomReportsGenerate';
    public const REDIRECTION_PATH = 'alphateam_reports/customreport/index';

    /**
     * @var RedirectFactory $resultRedirectFactoryCustom
     */
    private RedirectFactory $resultRedirectFactoryCustom;

    /**
     * @var ReportGeneratorPool $reportGeneratorPool
     */
    private ReportGeneratorPool $reportGeneratorPool;

    /**
     * @var FileFactory $fileFactory
     */
    private FileFactory $fileFactory;

    /**
     * @param Action\Context $context
     * @param RedirectFactory $resultRedirectFactory
     * @param FileFactory $fileFactory
     * @param ReportGeneratorPool $reportGenerator
     */
    public function __construct(
        Action\Context $context,
        RedirectFactory $resultRedirectFactory,
        FileFactory $fileFactory,
        ReportGeneratorPool $reportGenerator
    ) {
        parent::__construct($context);
        $this->resultRedirectFactoryCustom = $resultRedirectFactory;
        $this->fileFactory = $fileFactory;
        $this->reportGeneratorPool = $reportGenerator;
    }

    /**
     * Executes the report generation process based on the provided report type.
     *
     * Validates the input for the report type, generates the report using the appropriate generator,
     * and handles redirection or file download depending on the outcome of the report generation.
     *
     * @return ResponseInterface|Redirect
     */
    public function execute(): ResponseInterface|Redirect
    {
        $resultRedirect = $this->resultRedirectFactoryCustom->create();
        $reportType = $this->getRequest()->getParam('report_type');

        if (!$reportType) {
            $this->messageManager->addErrorMessage(
                __('No report type selected.')
            );

            return $resultRedirect->setPath(self::REDIRECTION_PATH);
        }

        try {
            $generator = $this->reportGeneratorPool->get($reportType);
            $reportResult = $generator->generateReport();

            if (!empty($reportResult['redirect']) && !empty($reportResult['file_name'])) {
                $this->messageManager->addSuccessMessage(
                    __(
                        'Report "%1" generated successfully. You can download it from the export directory: %2',
                        $reportType,
                        $reportResult['file_name']
                    )
                );

                return $resultRedirect->setPath(self::REDIRECTION_PATH);
            }

            if (empty($reportResult['redirect']) && !empty($reportResult['file_name'])) {
                return $this->fileFactory->create(
                    $reportResult['file_name'],
                    [
                        'type' => 'filename',
                        'value' => 'export/' . $reportResult['file_name'],
                        'rm' => true        // Remove the file after sending it
                    ],
                    DirectoryList::VAR_DIR,
                    'text/csv'
                );
            }

            $this->messageManager->addErrorMessage(
                __('The report result is invalid.')
            );
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(
                __('Error generating report: %1', $e->getMessage())
            );
        }

        return $resultRedirect->setPath(self::REDIRECTION_PATH);
    }
}
