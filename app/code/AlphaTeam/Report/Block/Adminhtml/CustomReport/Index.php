<?php
declare(strict_types=1);

namespace AlphaTeam\Report\Block\Adminhtml\CustomReport;

use Magento\Backend\Block\Template;
use AlphaTeam\Report\Model\Config\Source\ReportsList as ReportType;

class Index extends Template
{
    /**
     * @var ReportType
     */
    private ReportType $reportTypeSource;

    /**
     * @param Template\Context $context
     * @param ReportType $reportTypeSource
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ReportType $reportTypeSource,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->reportTypeSource = $reportTypeSource;
    }

    /**
     * Generates and retrieves the URL for running the report.
     *
     * @return string The URL for report generation.
     */
    public function getRunUrl(): string
    {
        return $this->getUrl('alphateam_reports/customreport/generate');
    }

    /**
     * Retrieve available options for report types
     *
     * @return array List of report type options
     */
    public function getReportTypeOptions(): array
    {
        return $this->reportTypeSource->toOptionArray();
    }
}
