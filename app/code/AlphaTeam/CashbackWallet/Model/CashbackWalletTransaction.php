<?php

namespace AlphaTeam\CashbackWallet\Model;

use AlphaTeam\CashbackWallet\Api\Data\CashbackWalletTransactionInterface;
use AlphaTeam\CashbackWallet\Model\ResourceModel\CashbackWalletTransaction as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class CashbackWalletTransaction extends AbstractModel implements CashbackWalletTransactionInterface
{
    /**
     * Define resource model
     */
    protected function _construct(): void
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * Get Transaction ID
     *
     * @return int|null
     */
    public function getTransactionId(): ?int
    {
        return $this->getData(self::TRANSACTION_ID);
    }

    /**
     * Set Transaction ID
     *
     * @param int $transactionId
     * @return CashbackWalletTransactionInterface
     */
    public function setTransactionId(int $transactionId): CashbackWalletTransactionInterface
    {
        return $this->setData(self::TRANSACTION_ID, $transactionId);
    }

    /**
     * Get Wallet ID
     *
     * @return int|null
     */
    public function getWalletId(): ?int
    {
        return $this->getData(self::WALLET_ID);
    }

    /**
     * Set Wallet ID
     *
     * @param int $walletId
     * @return CashbackWalletTransactionInterface
     */
    public function setWalletId(int $walletId): CashbackWalletTransactionInterface
    {
        return $this->setData(self::WALLET_ID, $walletId);
    }

    /**
     * Get Transaction Type
     *
     * @return string|null
     */
    public function getTransactionType(): ?string
    {
        return $this->getData(self::TRANSACTION_TYPE);
    }

    /**
     * Set Transaction Type
     *
     * @param string $transactionType
     * @return CashbackWalletTransactionInterface
     */
    public function setTransactionType(string $transactionType): CashbackWalletTransactionInterface
    {
        return $this->setData(self::TRANSACTION_TYPE, $transactionType);
    }

    /**
     * Get Amount
     *
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->getData(self::AMOUNT);
    }

    /**
     * Set Amount
     *
     * @param float $amount
     * @return CashbackWalletTransactionInterface
     */
    public function setAmount(float $amount): CashbackWalletTransactionInterface
    {
        return $this->setData(self::AMOUNT, $amount);
    }

    /**
     * Get Order ID
     *
     * @return int|null
     */
    public function getOrderId(): ?int
    {
        return $this->getData(self::ORDER_ID);
    }

    /**
     * Set Order ID
     *
     * @param int $orderId
     * @return CashbackWalletTransactionInterface
     */
    public function setOrderId(int $orderId): CashbackWalletTransactionInterface
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * Get Note
     *
     * @return string|null
     */
    public function getNote(): ?string
    {
        return $this->getData(self::NOTE);
    }

    /**
     * Set Note
     *
     * @param string $note
     * @return CashbackWalletTransactionInterface
     */
    public function setNote(string $note): CashbackWalletTransactionInterface
    {
        return $this->setData(self::NOTE, $note);
    }

    /**
     * Get Created At
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set Created At
     *
     * @param string $createdAt
     * @return CashbackWalletTransactionInterface
     */
    public function setCreatedAt(string $createdAt): CashbackWalletTransactionInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
}
