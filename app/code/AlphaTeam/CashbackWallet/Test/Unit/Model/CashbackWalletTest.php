<?php

namespace AlphaTeam\CashbackWallet\Test\Unit\Model;

use AlphaTeam\CashbackWallet\Model\CashbackWallet;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use PHPUnit\Framework\TestCase;

class CashbackWalletTest extends TestCase
{
    /** @var CashbackWallet */
    private CashbackWallet $model;

    protected function setUp(): void
    {
        $contextMock = $this->createMock(Context::class);
        $registryMock = $this->createMock(Registry::class);

        $resourceModelMock = $this->getMockBuilder(\Magento\Framework\Model\ResourceModel\Db\AbstractDb::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->model = new CashbackWallet(
            $contextMock,
            $registryMock,
            $resourceModelMock
        );
    }

    public function testGetAndSetEntityId()
    {
        $entityId = 1;
        $this->model->setEntityId($entityId);
        $this->assertEquals($entityId, $this->model->getEntityId());
    }

    public function testGetAndSetCustomerId()
    {
        $customerId = 123;
        $this->model->setCustomerId($customerId);
        $this->assertEquals($customerId, $this->model->getCustomerId());
    }

    public function testGetAndSetBalance()
    {
        $balance = 100.50;
        $this->model->setBalance($balance);
        $this->assertEquals($balance, $this->model->getBalance());
    }

    public function testGetAndSetTotalEarned()
    {
        $totalEarned = 150.75;
        $this->model->setTotalEarned($totalEarned);
        $this->assertEquals($totalEarned, $this->model->getTotalEarned());
    }

    public function testGetAndSetTotalUsed()
    {
        $totalUsed = 50.25;
        $this->model->setTotalUsed($totalUsed);
        $this->assertEquals($totalUsed, $this->model->getTotalUsed());
    }

    public function testGetAndSetStatus()
    {
        $status = 1;
        $this->model->setStatus($status);
        $this->assertEquals($status, $this->model->getStatus());
    }

    public function testGetAndSetLastUpdated()
    {
        $lastUpdated = '2024-12-29 12:00:00';
        $this->model->setLastUpdated($lastUpdated);
        $this->assertEquals($lastUpdated, $this->model->getLastUpdated());
    }

    public function testGetAndSetCreatedAt()
    {
        $createdAt = '2024-12-28 15:30:00';
        $this->model->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $this->model->getCreatedAt());
    }
}
