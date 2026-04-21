<?php
declare(strict_types=1);

namespace AlphaTeam\Report\Model\ReportGeneratorPool;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
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
     * @var FileDriver
     */
    private FileDriver $fileDriver;

    /**
     * @var DataProviderInterface $dataProvider
     */
    protected DataProviderInterface $dataProvider;

    /**
     * @param DirectoryList $directoryList
     * @param FileDriver $fileDriver
     * @param DataProviderInterface $dataProvider
     */
    public function __construct(
        DirectoryList         $directoryList,
        FileDriver            $fileDriver,
        DataProviderInterface $dataProvider,
    ) {
        $this->directoryList = $directoryList;
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
     * Writes data to a CSV file.
     *
     * @param iterable $data
     * @return string
     * @throws FileSystemException
     */
    protected function writeFile(iterable $data): string
    {
        $varPath = $this->directoryList->getPath(DirectoryList::VAR_DIR);
        $exportDir = $varPath . static::FILE_PATH;

        if (!$this->fileDriver->isExists($exportDir)) {
            $this->fileDriver->createDirectory($exportDir);
        }

        $fileName = date('Ymd_His') . '_' . static::FILE_NAME . '.csv';
        $filePath = $exportDir . '/' . $fileName;

        $fileHandle = $this->fileDriver->fileOpen($filePath, 'w');

        $headersWritten = false;
        $headers = [];

        try {
            foreach ($data as $row) {
                if (!$headersWritten) {
                    $headers = array_keys($row);
                    $this->fileDriver->filePutCsv($fileHandle, $headers);
                    $headersWritten = true;
                }

                $csvRow = [];
                foreach ($headers as $field) {
                    $csvRow[] = $row[$field] ?? '';
                }

                $this->fileDriver->filePutCsv($fileHandle, $csvRow);
            }
        } finally {
            $this->fileDriver->fileClose($fileHandle);
        }

        return $filePath;
    }
}
