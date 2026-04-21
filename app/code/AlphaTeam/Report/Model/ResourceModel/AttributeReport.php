<?php
declare(strict_types=1);

namespace AlphaTeam\Report\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class AttributeReport extends AbstractDb
{
    /**
     * Initialize the model with the main table and primary key field.
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init('catalog_product_entity', 'entity_id');
    }

    /**
     * Retrieves report data for a given attribute and product type in batches.
     *
     * @param string $attributeCode
     * @param string $productType
     * @param int $batchSize
     * @param int $lastEntityId
     * @return array
     */
    public function getReportData(
        string $attributeCode,
        string $productType,
        int $batchSize = 500,
        int $lastEntityId = 0
    ): array {
        $connection = $this->getConnection();

        $attribute = $connection->fetchRow(
            $connection->select()
                ->from(
                    ['ea' => $this->getTable('eav_attribute')],
                    ['attribute_id', 'backend_type', 'attribute_code']
                )
                ->where('ea.attribute_code = ?', $attributeCode)
        );

        if (!$attribute) {
            return [];
        }

        $backendType = (string)$attribute['backend_type'];
        $attributeId = (int)$attribute['attribute_id'];

        if ($backendType === 'static') {
            $select = $connection->select()
                ->from(
                    ['cpe' => $this->getTable('catalog_product_entity')],
                    [
                        'entity_id',
                        'sku',
                        'value' => $attributeCode
                    ]
                )
                ->where('cpe.type_id = ?', $productType)
                ->where('cpe.entity_id > ?', $lastEntityId)
                ->order('cpe.entity_id ASC')
                ->limit($batchSize);

            return $connection->fetchAll($select);
        }

        $valueTable = $this->getTable('catalog_product_entity_' . $backendType);

        $select = $connection->select()
            ->from(
                ['cpe' => $this->getTable('catalog_product_entity')],
                [
                    'entity_id',
                    'sku'
                ]
            )
            ->joinLeft(
                ['cpev' => $valueTable],
                sprintf(
                    'cpev.entity_id = cpe.entity_id AND cpev.attribute_id = %d AND cpev.store_id = 0',
                    $attributeId
                ),
                ['value']
            )
            ->where('cpe.type_id = ?', $productType)
            ->where('cpe.entity_id > ?', $lastEntityId)
            ->order('cpe.entity_id ASC')
            ->limit($batchSize);

        return $connection->fetchAll($select);
    }

    /**
     * Generates batches of report data based on the provided attribute code and product type.
     *
     * @param string $attributeCode The attribute code used to filter the report data.
     * @param string $productType The product type used to filter the report data.
     * @param int $batchSize The number of records to include in each batch. Defaults to 500.
     * @return \Generator Yields batches of report data as arrays.
     */
    public function getReportDataBatches(
        string $attributeCode,
        string $productType,
        int $batchSize = 500
    ): \Generator {
        $lastEntityId = 0;

        do {
            $rows = $this->getReportData(
                $attributeCode,
                $productType,
                $batchSize,
                $lastEntityId
            );

            if (empty($rows)) {
                break;
            }

            yield $rows;

            $lastRow = end($rows);
            $lastEntityId = (int)$lastRow['entity_id'];
        } while (count($rows) === $batchSize);
    }
}
