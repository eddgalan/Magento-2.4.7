<?php
declare(strict_types=1);

namespace AlphaTeam\Report\Model\ResourceModel\SalesOrderDetails;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use AlphaTeam\Report\Model\SalesOrderDetails as Model;
use AlphaTeam\Report\Model\ResourceModel\SalesOrderDetails as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * Initializes the resource model for the current model.
     *
     * This method sets up the mapping between the model and its corresponding resource model.
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(Model::class, ResourceModel::class);
    }

    /**
     * Initializes the select query for the collection, adding the necessary columns and joins.
     *
     * The method sets up the SQL SELECT statement for the collection including relevant
     * fields to be retrieved from the main table and associated tables. It performs joins
     * with the sales_order_item and sales_order_payment tables to include additional data
     * related to order items and payment methods respectively.
     *
     * @return self
     */
    protected function _initSelect(): self
    {
        parent::_initSelect();

        $connection = $this->getConnection();

        $this->getSelect()
            ->columns([
                'entity_id'        => 'main_table.entity_id',
                'increment_id'     => 'main_table.increment_id',
                'state'            => 'main_table.state',
                'status'           => 'main_table.status',
                'customer_email'   => 'main_table.customer_email',
                'subtotal'         => 'main_table.subtotal',
                'discount_amount'  => 'main_table.discount_amount',
                'coupon_code'      => 'main_table.coupon_code',
                'applied_rule_ids' => 'main_table.applied_rule_ids',
                'shipping_amount'  => 'main_table.shipping_amount',
                'tax_amount'       => 'main_table.tax_amount',
                'grand_total'      => 'main_table.grand_total',
                'total_paid'       => 'main_table.total_paid',
                'total_refunded'   => 'main_table.total_refunded',
                'created_at'       => 'main_table.created_at',
                'updated_at'       => 'main_table.updated_at',
            ])
            ->joinInner(
                ['soi' => $this->getTable('sales_order_item')],
                'main_table.entity_id = soi.order_id',
                [
                    'item_id'              => 'soi.item_id',
                    'sku'                  => 'soi.sku',
                    'name'                 => 'soi.name',
                    'product_type'         => 'soi.product_type',
                    'base_price'           => 'soi.base_price',
                    'base_price_incl_tax'  => 'soi.base_price_incl_tax',
                    'item_tax_amount'      => 'soi.tax_amount',
                    'item_discount_amount' => 'soi.discount_amount',
                    'discount_percent'     => 'soi.discount_percent',
                    'base_row_total'       => 'soi.base_row_total',
                    'row_total_incl_tax'   => 'soi.row_total_incl_tax',
                    'qty_ordered'          => 'soi.qty_ordered',
                    'qty_invoiced'         => 'soi.qty_invoiced',
                    'qty_shipped'          => 'soi.qty_shipped',
                    'qty_canceled'         => 'soi.qty_canceled',
                    'qty_refunded'         => 'soi.qty_refunded',
                ]
            )
            ->joinLeft(
                ['sop' => $this->getTable('sales_order_payment')],
                'main_table.entity_id = sop.parent_id',
                [
                    'payment_method'        => 'sop.method',
                    'amount_paid'           => 'sop.amount_paid',
                    'additional_information'=> 'sop.additional_information',
                ]
            );

        return $this;
    }
}
