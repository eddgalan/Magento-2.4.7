<?php
declare(strict_types=1);

namespace AlphaTeam\Report\Model\ReportGeneratorPool;

use AlphaTeam\Report\Model\ReportGeneratorPool\ReportGeneratorAbstract;

class PriceReport extends ReportGeneratorAbstract
{
    public const FILE_NAME = 'AlphaTeam_PriceReport';
    public const REPORT_TYPE = 'price_report';
    public const REPORT_TYPE_LABEL = 'Price Report';
    public const SAVE_IN_EXPORT_DIR = false;
}
