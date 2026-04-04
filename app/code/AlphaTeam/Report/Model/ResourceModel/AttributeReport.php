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
     * Retrieves report data for a specific attribute and product type.
     *
     * @param string $attributeCode
     * @param string $productType
     * @return array
     */
    public function getReportData(string $attributeCode, string $productType): array
    {
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
                    ['sku', 'value' => $attributeCode]
                )
                ->where('cpe.type_id = ?', $productType)
                ->order('cpe.sku ASC');

            return $connection->fetchAll($select);
        }

        $valueTable = $this->getTable('catalog_product_entity_' . $backendType);

        $select = $connection->select()
            ->from(
                ['cpe' => $this->getTable('catalog_product_entity')],
                ['sku']
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
            ->order('cpe.sku ASC');

        return $connection->fetchAll($select);
    }
}
