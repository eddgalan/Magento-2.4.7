<?php
declare(strict_types=1);

namespace AlphaTeam\Report\Model\ReportGeneratorPool;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\File\Csv as CsvProcessor;
use Magento\Framework\Filesystem\Driver\File as FileDriver;
use AlphaTeam\Report\Api\ReportGeneratorInterface;
use AlphaTeam\Report\Api\DataProviderInterface;

abstract class ReportGeneratorAbstract implements ReportGeneratorInterface
{
    public const FILE_PATH = '/export';
    public const FILE_NAME = 'file_name';
    public const REPORT_TYPE = 'NotDefined';
    public const REPORT_TYPE_LABEL = 'Not Defined';
    public const SAVE_IN_EXPORT_DIR = true;

    /**
     * @var DirectoryList
     */
    private DirectoryList $directoryList;

    /**
     * @var CsvProcessor
     */
    private CsvProcessor $csvProcessor;

    /**
     * @var FileDriver
     */
    private FileDriver $fileDriver;

    /**
     * @var DataProviderInterface $dataProvider
     */
    protected DataProviderInterface $dataProvider;

    /**
     * @param DirectoryList $directoryList
     * @param CsvProcessor $csvProcessor
     * @param FileDriver $fileDriver
     * @param DataProviderInterface $dataProvider
     */
    public function __construct(
        DirectoryList         $directoryList,
        CsvProcessor          $csvProcessor,
        FileDriver            $fileDriver,
        DataProviderInterface $dataProvider,
    ) {
        $this->directoryList = $directoryList;
        $this->csvProcessor = $csvProcessor;
        $this->fileDriver = $fileDriver;
        $this->dataProvider = $dataProvider;
    }

    /**
     * Generates a report by collecting data and writing it to a file.
     *
     * @return array
     * @throws FileSystemException
     */
    public function generateReport(): array
    {
        try {
            $data = $this->dataProvider->collectData();
            $filePath = $this->writeFile($data);

            return [
                'file_name' => basename($filePath),
                'file_path' => $filePath,
                'redirect' => static::SAVE_IN_EXPORT_DIR    // True: Save a report in the export directory
            ];
        } catch (\Exception $e) {
            // ToDo: Save error in log file
            throw $e;
        }
    }

    /**
     * Writes the provided data array into a CSV file and saves it in the export directory.
     *
     * @param array $data
     * @return string
     * @throws FileSystemException
     */
    protected function writeFile(array $data): string
    {
        $rows = [];

        if (!empty($data)) {
            $headers = array_keys($data[0]);
            $rows[] = $headers;

            foreach ($data as $row) {
                $csvRow = [];
                foreach ($headers as $field) {
                    $csvRow[] = $row[$field] ?? '';
                }
                $rows[] = $csvRow;
            }
        }

        $varPath = $this->directoryList->getPath(DirectoryList::VAR_DIR);
        $exportDir = $varPath . static::FILE_PATH;

        if (!$this->fileDriver->isExists($exportDir)) {
            $this->fileDriver->createDirectory($exportDir);
        }

        $fileName = date('Ymd_His') . '_' . static::FILE_NAME . '.csv';
        $filePath = $exportDir . '/' . $fileName;

        $this->csvProcessor->saveData($filePath, $rows);

        return $filePath;
    }
}
