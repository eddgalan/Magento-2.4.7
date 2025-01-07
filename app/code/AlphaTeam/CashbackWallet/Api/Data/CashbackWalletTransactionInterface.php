<?php

namespace AlphaTeam\CashbackWallet\Api\Data;

interface CashbackWalletTransactionInterface
{
    public const TRANSACTION_ID = 'transaction_id';
    public const WALLET_ID = 'wallet_id';
    public const TRANSACTION_TYPE = 'transaction_type';
    public const AMOUNT = 'amount';
    public const ORDER_ID = 'order_id';
    public const NOTE = 'note';
    public const CREATED_AT = 'created_at';

    /**
     * Get TransactionId
     *
     * @return int|null
     */
    public function getTransactionId(): ?int;

    /**
     * Set Transaction ID
     *
     * @param int $transactionId
     * @return CashbackWalletTransactionInterface
     */
    public function setTransactionId(int $transactionId): CashbackWalletTransactionInterface;

    /**
     * Get Wallet ID
     *
     * @return int|null
     */
    public function getWalletId(): ?int;

    /**
     * Set Wallet ID
     *
     * @param int $walletId
     * @return CashbackWalletTransactionInterface
     */
    public function setWalletId(int $walletId): CashbackWalletTransactionInterface;

    /**
     * Get Transaction Type
     *
     * @return string|null
     */
    public function getTransactionType(): ?string;

    /**
     * Set Transaction Type
     *
     * @param string $transactionType
     * @return CashbackWalletTransactionInterface
     */
    public function setTransactionType(string $transactionType): CashbackWalletTransactionInterface;

    /**
     * Get Amount
     *
     * @return float|null
     */
    public function getAmount(): ?float;

    /**
     * Set Amount
     *
     * @param float $amount
     * @return CashbackWalletTransactionInterface
     */
    public function setAmount(float $amount): CashbackWalletTransactionInterface;

    /**
     * Get Order ID
     *
     * @return int|null
     */
    public function getOrderId(): ?int;

    /**
     * Set Order ID
     *
     * @param int $orderId
     * @return CashbackWalletTransactionInterface
     */
    public function setOrderId(int $orderId): CashbackWalletTransactionInterface;

    /**
     * Get Note
     *
     * @return string|null
     */
    public function getNote(): ?string;

    /**
     * Set Note
     *
     * @param string $note
     * @return CashbackWalletTransactionInterface
     */
    public function setNote(string $note): CashbackWalletTransactionInterface;

    /**
     * Get Created At
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Set Created At
     *
     * @param string $createdAt
     * @return CashbackWalletTransactionInterface
     */
    public function setCreatedAt(string $createdAt): CashbackWalletTransactionInterface;
}
