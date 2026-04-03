<?php
declare(strict_types=1);

namespace AlphaTeam\Report\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class AttributeReport extends AbstractDb
{
    /**
     * @var string $attributeCode
     */
    private string $attributeCode;

    /**
     * @var string $productType
     */
    private string $productType;

    /**
     * @param Context $context
     * @param string $attributeCode
     * @param string $productType
     * @param null $connectionName
     */
    public function __construct(
        Context $context,
        string $attributeCode = '',
        string $productType = '',
                $connectionName = null
    ) {
        $this->attributeCode = $attributeCode;
        $this->productType = $productType;
        parent::__construct($context, $connectionName);
    }

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
     * Retrieves report data based on the provided attribute code.
     *
     * This method fetches data from the database for a specific attribute associated
     * with configurable products. The data will include product identifiers (SKU)
     * and their corresponding attribute values, determined by whether the attribute
     * is of a static type or a dynamic type (with backend storage).
     *
     * @return array
     */
    public function getReportData(): array
    {
        $connection = $this->getConnection();

        $attribute = $connection->fetchRow(
            $connection->select()
                ->from(
                    ['ea' => $this->getTable('eav_attribute')],
                    ['attribute_id', 'backend_type', 'attribute_code']
                )
                ->where('ea.attribute_code = ?', $this->attributeCode)
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
                    ['sku', 'value' => $this->attributeCode]
                )
                ->where('cpe.type_id = ?', 'configurable')
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
            ->where('cpe.type_id = ?', $this->productType)
            ->order('cpe.sku ASC');

        return $connection->fetchAll($select);
    }
}
