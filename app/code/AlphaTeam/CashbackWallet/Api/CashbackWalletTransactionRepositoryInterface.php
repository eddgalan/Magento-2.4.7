<?php

namespace AlphaTeam\CashbackWallet\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use AlphaTeam\CashbackWallet\Api\Data\CashbackWalletTransactionInterface;

interface CashbackWalletTransactionRepositoryInterface
{
    /**
     * Save method. Insert/Update a cashback wallet transaction
     *
     * @param CashbackWalletTransactionInterface $transaction
     * @return CashbackWalletTransactionInterface
     */
    public function save(CashbackWalletTransactionInterface $transaction): CashbackWalletTransactionInterface;

    /**
     * Get a Cashback Wallet Transaction by ID
     *
     * @param int $id
     * @return CashbackWalletTransactionInterface|null
     */
    public function getById(int $id): ?CashbackWalletTransactionInterface;

    /**
     * Get multiple records using SearchCriteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Delete a Cashback Wallet Transaction
     *
     * @param CashbackWalletTransactionInterface $transaction
     * @return bool
     */
    public function delete(CashbackWalletTransactionInterface $transaction): bool;

    /**
     * Delete a Cashback Wallet Transaction using ID
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;
}
