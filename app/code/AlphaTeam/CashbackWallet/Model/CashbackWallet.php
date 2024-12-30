<?php

namespace AlphaTeam\CashbackWallet\Model;

use AlphaTeam\CashbackWallet\Model\ResourceModel\CashbackWallet as ResourceModel;
use AlphaTeam\CashbackWallet\Api\Data\CashbackWalletInterface;
use Magento\Framework\Model\AbstractModel;

class CashbackWallet extends AbstractModel implements CashbackWalletInterface
{
    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @return int|null
     */
    public function getEntityId(): ?int
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * @param $entityId
     * @return CashbackWalletInterface
     */
    public function setEntityId($entityId): CashbackWalletInterface
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * @param $customerId
     * @return CashbackWalletInterface
     */
    public function setCustomerId($customerId): CashbackWalletInterface
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * @return float|null
     */
    public function getBalance(): ?float
    {
        return $this->getData(self::BALANCE);
    }

    /**
     * @param float $balance
     * @return CashbackWalletInterface
     */
    public function setBalance(float $balance): CashbackWalletInterface
    {
        return $this->setData(self::BALANCE, $balance);
    }

    /**
     * @return float|null
     */
    public function getTotalEarned(): ?float
    {
        return $this->getData(self::TOTAL_EARNED);
    }

    /**
     * @param float $totalEarned
     * @return CashbackWalletInterface
     */
    public function setTotalEarned(float $totalEarned): CashbackWalletInterface
    {
        return $this->setData(self::TOTAL_EARNED, $totalEarned);
    }

    /**
     * @return float|null
     */
    public function getTotalUsed(): ?float
    {
        return $this->getData(self::TOTAL_USED);
    }

    /**
     * @param float $totalUsed
     * @return CashbackWalletInterface
     */
    public function setTotalUsed(float $totalUsed): CashbackWalletInterface
    {
        return $this->setData(self::TOTAL_USED, $totalUsed);
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @param int $status
     * @return CashbackWalletInterface
     */
    public function setStatus(int $status): CashbackWalletInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @return string|null
     */
    public function getLastUpdated(): ?string
    {
        return $this->getData(self::LAST_UPDATED);
    }

    /**
     * @param string $lastUpdated
     * @return CashbackWalletInterface
     */
    public function setLastUpdated(string $lastUpdated): CashbackWalletInterface
    {
        return $this->setData(self::LAST_UPDATED, $lastUpdated);
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @param string $createdAt
     * @return CashbackWalletInterface
     */
    public function setCreatedAt(string $createdAt): CashbackWalletInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
}
