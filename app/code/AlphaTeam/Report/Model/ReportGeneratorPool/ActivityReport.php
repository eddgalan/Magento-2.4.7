<?php
declare(strict_types=1);

namespace AlphaTeam\Report\Model\ReportGeneratorPool;

use AlphaTeam\Report\Model\ReportGeneratorPool\ReportGeneratorAbstract;

class ActivityReport extends ReportGeneratorAbstract
{
    public const FILE_NAME = 'AlphaTeam_ActivityReport';
    public const REPORT_TYPE = 'activity_report';
    public const REPORT_TYPE_LABEL = 'Activity Report';
    public const SAVE_IN_EXPORT_DIR = true;
}
