<?php

namespace AlphaTeam\CashbackWallet\Api\Data;

/**
 * Interface CashbackWalletInterface
 */
interface CashbackWalletInterface
{
    public const ENTITY_ID = 'entity_id';
    public const CUSTOMER_ID = 'customer_id';
    public const BALANCE = 'balance';
    public const TOTAL_EARNED = 'total_earned';
    public const TOTAL_USED = 'total_used';
    public const STATUS = 'status';
    public const LAST_UPDATED = 'last_updated';
    public const CREATED_AT = 'created_at';

    /**
     * Get Wallet ID
     *
     * @return int|null
     */
    public function getEntityId(): ?int;

    /**
     * Set Wallet ID
     *
     * @param int $entityId
     * @return $this
     */
    public function setEntityId(int $entityId): CashbackWalletInterface;

    /**
     * Get Customer ID
     *
     * @return int|null
     */
    public function getCustomerId(): ?int;

    /**
     * Set Customer ID
     *
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId(int $customerId): CashbackWalletInterface;

    /**
     * Get Wallet Balance
     *
     * @return float|null
     */
    public function getBalance(): ?float;

    /**
     * Set Wallet Balance
     *
     * @param float $balance
     * @return $this
     */
    public function setBalance(float $balance): CashbackWalletInterface;

    /**
     * Get Total Earned
     *
     * @return float|null
     */
    public function getTotalEarned(): ?float;

    /**
     * Set Total Earned
     *
     * @param float $totalEarned
     * @return $this
     */
    public function setTotalEarned(float $totalEarned): CashbackWalletInterface;

    /**
     * Get Total Used
     *
     * @return float|null
     */
    public function getTotalUsed(): ?float;

    /**
     * Set Total Used
     *
     * @param float $totalUsed
     * @return $this
     */
    public function setTotalUsed(float $totalUsed): CashbackWalletInterface;

    /**
     * Get Status
     *
     * @return int|null
     */
    public function getStatus(): ?int;

    /**
     * Set Status
     *
     * @param int $status
     * @return $this
     */
    public function setStatus(int $status): CashbackWalletInterface;

    /**
     * Get Last Updated Timestamp
     *
     * @return string|null
     */
    public function getLastUpdated(): ?string;

    /**
     * Set Last Updated Timestamp
     *
     * @param string $lastUpdated
     * @return $this
     */
    public function setLastUpdated(string $lastUpdated): CashbackWalletInterface;

    /**
     * Get Created At Timestamp
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Set Created At Timestamp
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt): CashbackWalletInterface;
}
