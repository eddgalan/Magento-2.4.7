<?php

namespace AlphaTeam\CashbackWallet\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use AlphaTeam\CashbackWallet\Api\Data\CashbackWalletInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface CashbackWalletRepositoryInterface
{
    /**
     * Save method. Insert/Update a cashback wallet
     *
     * @param CashbackWalletInterface $cashbackWallet
     * @return CashbackWalletInterface
     */
    public function save(CashbackWalletInterface $cashbackWallet): CashbackWalletInterface;

    /**
     * Get a Cashback Wallet by Id
     *
     * @param int $id
     * @return CashbackWalletInterface
     */
    public function getById(int $id): CashbackWalletInterface;

    /**
     * Get multiple records using SearchCriteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Delete a Cashback Wallet
     *
     * @param CashbackWalletInterface $cashbackWallet
     * @return bool
     */
    public function delete(CashbackWalletInterface $cashbackWallet): bool;

    /**
     * Delete a Cashback Wallet using id
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;
}
