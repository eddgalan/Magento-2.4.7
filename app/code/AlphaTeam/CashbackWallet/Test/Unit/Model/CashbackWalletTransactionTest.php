<?php

namespace AlphaTeam\CashbackWallet\Test\Unit\Model;

use AlphaTeam\CashbackWallet\Model\CashbackWalletTransaction;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use PHPUnit\Framework\TestCase;

class CashbackWalletTransactionTest extends TestCase
{
    /**
     * @var CashbackWalletTransaction
     */
    private CashbackWalletTransaction $model;

    protected function setUp(): void
    {
        $contextMock = $this->createMock(Context::class);
        $registryMock = $this->createMock(Registry::class);

        $resourceModelMock = $this->getMockBuilder(\Magento\Framework\Model\ResourceModel\Db\AbstractDb::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->model = new CashbackWalletTransaction(
            $contextMock,
            $registryMock,
            $resourceModelMock
        );
    }

    public function testSetAndGetTransactionId(): void
    {
        $transactionId = 123;
        $this->model->setTransactionId($transactionId);
        $this->assertEquals($transactionId, $this->model->getTransactionId());
    }

    public function testSetAndGetWalletId(): void
    {
        $walletId = 456;
        $this->model->setWalletId($walletId);
        $this->assertEquals($walletId, $this->model->getWalletId());
    }

    public function testSetAndGetTransactionType(): void
    {
        $transactionType = 'Earned Cashback';
        $this->model->setTransactionType($transactionType);
        $this->assertEquals($transactionType, $this->model->getTransactionType());
    }

    public function testSetAndGetAmount(): void
    {
        $amount = 99.99;
        $this->model->setAmount($amount);
        $this->assertEquals($amount, $this->model->getAmount());
    }

    public function testSetAndGetOrderId(): void
    {
        $orderId = 789;
        $this->model->setOrderId($orderId);
        $this->assertEquals($orderId, $this->model->getOrderId());
    }

    public function testSetAndGetNote(): void
    {
        $note = 'Transaction for testing purposes.';
        $this->model->setNote($note);
        $this->assertEquals($note, $this->model->getNote());
    }

    public function testSetAndGetCreatedAt(): void
    {
        $createdAt = '2025-01-01 10:00:00';
        $this->model->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $this->model->getCreatedAt());
    }
}
